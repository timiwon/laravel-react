<?php

namespace App\Services;

use DateTime;
use App\Http\Resources\BaseResource;
use App\Repositories\BusinessRepository;
use App\Repositories\AreaRepository;
use App\Repositories\TableRepository;
use App\Repositories\OpeningTimeRepository;
use App\Repositories\BookingRepository;

class BookingService extends BaseService
{
    protected $businessRepo;
    protected $areaRepo;
    protected $tableRepo;

    public function __construct(
        BookingRepository $repo,
        TableRepository $tableRepo,
        AreaRepository $areaRepo,
        BusinessRepository $businessRepo,
        OpeningTImeRepository $openingTimeRepo
    ) {
        parent::__construct($repo);
        $this->tableRepo = $tableRepo;
        $this->areaRepo = $areaRepo;
        $this->businessRepo = $businessRepo;
        $this->openingTimeRepo = $openingTimeRepo;
    }

    public function getBookingsOnTables($params, $perPage) {
        return BaseResource::collection($this->repo->getBookingsOnTables(
            $params['table_id'],
            $params['booking_date'],
            $perPage,
            $params['status'] ?? null
        ));
    }

    public function createBooking(string $businessId, array $tableIds, array $attributes) {
        // select table
        if (empty($tableIds)) {
            // only get available online table for enduser booking
            $availableTables = $this->getAvailableTablesForBooking(
                $businessId,
                true,
                $attributes['booking_date'],
                $attributes['booking_time'],
                $attributes['duration'],
                $attributes['guests_number'],
                $attributes['prepayment_amount'] ?? 0
            );
        } else {
            $availableTables = $this->isTablesAvailable(
                $businessId,
                $tableIds,
                $attributes['booking_date'],
                $attributes['booking_time'],
                $attributes['duration'],
                $attributes['guests_number'],
                $attributes['prepayment_amount'] ?? 0
            );
        }

        // check tabstatusle is available for booking
        if (!$availableTables) {
            abort(400, 'selected time is not available for booking anymore');
        }

        $attributes['status'] = 'pending';
        $booking = $this->repo->create($attributes);
        $booking->tables()->attach(array_column($availableTables, 'id'));
        return new BaseResource($booking);
    }

    public function updateBooking(string $id, array $attributes) {
        $booking = $this->repo->find($id);

        // check for updating status
        switch($attributes['status']) {
            case 'seated':
                if (in_array($booking->status, [
                    'completed',
                    'cancelled',
                    'deleted',
                    'failed'])) {
                    abort(400, 'not allow update status');
                }
                break;
            case 'completed':
                if (in_array($booking->status, [
                    'pending',
                    'accepted',
                    'cancelled',
                    'deleted',
                    'failed'])) {
                    abort(400, 'not allow update status');
                }
                break;
            case 'cancelled':
                if (in_array($booking->status, ['seated','completed', 'deleted'])) {
                    abort(400, 'not allow update status');
                }
                break;
            default:
                abort(400, 'not allow update status');
                break;
        };

        // check for updating duration
        if ($attributes['duration'] !== $booking->duration) {
            $diff = strtotime($attributes['duration']) - strtotime("00:00:00");
            $leaveTime = date('H:i', strtotime($booking->booking_time) + $diff);

            $bookingTableIds = array_column($booking->tables->toArray(), 'id');
            $existsBooking = $this->repo->getAvailableBookingsOnSpecialTablesAtSpecialRangeTime(
                $bookingTableIds,
                $booking->booking_date,
                $booking->booking_time,
                $leaveTime
            );

            if (!empty($existsBooking->toArray())) {
                abort(400, 'can not increase duration');
            }
        }

        $booking = $this->repo->update($id, $attributes);
        return new BaseResource($booking);
    }

    public function getAvailableTablesForBooking(
        $businessId,
        $isAvailableOnline,
        $onDate,
        $onTime,
        $duration,
        $guestsNumber,
        $prepaymentAmount
    ) {
        // get all tables in a business fixed with guests number
        $tables = $this->tableRepo->getAllTablesInBusinessWithGuestsNumber(
            $businessId,
            $isAvailableOnline,
            $guestsNumber
        );

        // get available tables for booking
        $validatedData = $this->checkBookingRules(
            $businessId,
            $onDate,
            $onTime,
            $duration,
            $prepaymentAmount,
            $guestsNumber,
            $tables
        );

        if (empty($validatedData['available_tables'])) {
            return false;
        }

        return $validatedData['available_tables'][0];
    }

    public function getAvailableGuestsNumber($businessId) {
        // get all available booking online tables in business
        $tables = $this->tableRepo->getAllTablesInBusiness($businessId, true);
        $resuts = [];
        foreach($tables as $table) {
            $resuts = array_merge($resuts, range($table->min_guests, $table->max_guests));
        }

        return array_unique($resuts, SORT_NUMERIC);
    }

    public function getAvailableTimesForBooking($businessId, $bookingDate) {
        $business = $this->businessRepo->find($businessId);
        $bookingTimesIntervals = [];

        $businessOpeningTime = $this->openingTimeRepo->getOnReferenceAtSpecialTime(
            'business',
            $businessId,
            'open',
            $bookingDate
        );
        if (!$businessOpeningTime) {
            $businessOpeningTime = $this->openingTimeRepo->getOnReferenceAtWeekDay(
                'business',
                $businessId,
                'open',
                $bookingDate,
            );
        }

        // get booking times interval on areas
        $isFirstTime = true;
        foreach ($business->areas as $area) {
            $openingTime = $this->openingTimeRepo->getOnReferenceAtSpecialTime(
                'area',
                $area->id,
                'open',
                $bookingDate
            );

            if (!$openingTime) {
                $openingTime = $this->openingTimeRepo->getOnReferenceAtWeekDay(
                    'area',
                    $area->id,
                    'open',
                    $bookingDate
                );
            }

            // get area rule first if not exists will get from business rule
            if ($openingTime) {
                $bookingTimesIntervals = array_merge(
                    $bookingTimesIntervals,
                    $this->getBookingTimesInterval($openingTime)
                );
            } else {
                if ($businessOpeningTime && $isFirstTime) {
                    $isFirstTime = false;
                    $bookingTimesIntervals = $this->getBookingTimesInterval($businessOpeningTime);
                }
            }
        }

        return array_map(
            fn ($val) => date('H:i', $val),
            array_unique($bookingTimesIntervals, SORT_NUMERIC)
        );
    }

    private function getBookingTimesInterval($openingTime) {
        $fromTime = strtotime($openingTime->from_time);
        $toTime = strtotime($openingTime->to_time);
        $timeInterval = strtotime($openingTime->bookingRule->time_interval);
        $diff = $timeInterval - strtotime("00:00:00");

        $results = [$fromTime];
        do {
            $fromTime += $diff;

            if ($fromTime <= $toTime) {
                array_push($results, $fromTime);
            }
        } while($fromTime < $toTime);

        return $results;
    }

    private function processOnErrorTables($key, $tableId, $message, &$availableTables, &$errors) {
        if (!array_key_exists($tableId, $errors)) {
            $errors[$tableId] = [
                'table_id' => $tableId,
                'error_message' => [$message]
            ];
        } else {
            array_push($errors[$tableId]['error_message'], $message);
        }

        // remove error table to avalable tables
        unset($availableTables[$key]);
    }

    private function checkBookingRules(
        $businessId,
        $bookingDateAttribute,
        $bookingTimeAttribute,
        $durationAttribute,
        $prepaymentAmountAttribute,
        $guestsNumberAttribute,
        $availableTables
    ) {
        $bookedTablesAtBookingTime = $this->tableRepo->getBookedTables(
            $businessId,
            $bookingDateAttribute,
            $bookingTimeAttribute,
            $durationAttribute
        );

        $bookedTableAtBookingTimeIds = [];
        foreach ($bookedTablesAtBookingTime as $table) {
            array_push($bookedTableAtBookingTimeIds, $table->id);
            foreach ($table->combinations as $item) {
                array_push($bookedTableAtBookingTimeIds, $item->id);
            }
            foreach ($table->beCombinations as $item) {
                array_push($bookedTableAtBookingTimeIds, $item->id);
            }
        }

        // get booked items on booked date for checking rule max bookings and max guests
        $tables = $this->tableRepo->getAllTablesInBusiness($businessId);
        $tablesGroupByArea = [];
        foreach($tables as $table) {
            if (array_key_exists($table->area_id, $tablesGroupByArea)) {
                array_push($tablesGroupByArea[$table->area_id], $table->id);
            }
        }

        // calc total bookings & guests in area
        $currentBookingsNumber = [];
        $totalGuests = 0;
        $totalBookings = 0;
        foreach($tablesGroupByArea as $areaId => $tableIds) {
            $currentBookingsInArea = $this->repo->getAllBookingsOnSpecialTablesAtSpecialDate(
                $tableIds,
                $bookingDateAttribute
            )->toArray();

            $guestsNumber = array_sum(array_column($currentBookingsInArea, 'guests_number'));
            $bookingsNumber = count($currentBookingsInArea);
            $totalGuests += $guestsNumber;
            $totalBookings += $bookingsNumber;
            $currentBookingsNumber[$areaId]['guests'] = $guestsNumber;
            $currentBookingsNumber[$areaId]['bookings'] = $bookingsNumber;
        }

        $errors = [];
        $validateRules = [];
        $areaOpeningTimes = [];

        // get openingTime from business
        // priority on special date
        $businessOpeningTime = $this->openingTimeRepo->getOnReferenceAtSpecialTime(
            'business',
            $businessId,
            'open',
            $bookingDateAttribute,
            $bookingTimeAttribute
        );
        if (!$businessOpeningTime) {
            $businessOpeningTime = $this->openingTimeRepo->getOnReferenceAtWeekDay(
                'business',
                $businessId,
                'open',
                $bookingDateAttribute,
                $bookingTimeAttribute
            );
        }

        foreach($availableTables as $key => $table) {
            $isCheckingOnArea = true;

            if (in_array($table->id, $bookedTableAtBookingTimeIds)) {
                $this->processOnErrorTables($key, $table->id, 'table is booked', $availableTables, $errors);
                continue;
            }

            // TODO check for waiting prepayment, case cron timeout

            // get openingTime from area
            // get priority on special date
            if (in_array($table->area_id, $areaOpeningTimes)) {
                $openingTime = $areaOpeningTimes[$table->area_id];
            }else {
                $openingTime = $this->openingTimeRepo->getOnReferenceAtSpecialTime(
                    'area',
                    $table->area_id,
                    'open',
                    $bookingDateAttribute,
                    $bookingTimeAttribute
                );
                if (!$openingTime) {
                    $openingTime = $this->openingTimeRepo->getOnReferenceAtWeekDay(
                        'area',
                        $table->area_id,
                        'open',
                        $bookingDateAttribute,
                        $bookingTimeAttribute
                    );
                }
                $areaOpeningTimes[$table->area_id] = $openingTime;
            }

            if (!$openingTime) {
                $isCheckingOnArea = false;
                $openingTime = $businessOpeningTime;
            }

            // allow booking when openingTime not define
            if (!$openingTime) {
                $this->processOnErrorTables($key, $table->id, 'not in open time', $availableTables, $errors);
                continue;
            }

            // check on interval time
            $timesIntervals = $this->getBookingTimesInterval($openingTime);
            if (!in_array(strtotime($bookingTimeAttribute), $timesIntervals)) {
                $this->processOnErrorTables($key, $table->id, 'not in interval time', $availableTables, $errors);
                continue;
            }

            if (!in_array($openingTime->id, $validateRules)) {
                $validateRules[$openingTime->id] = [
                    'current_guests' => 0,
                ];
            }

            $bookingRule = $openingTime->bookingRule;

            if ($isCheckingOnArea) {
                $currentMaxBookings = $currentBookingsNumber[$table->area_id]['bookings'] + 1;
            } else {
                $currentMaxBookings = $totalBookings + 1;
            }

            if ($bookingRule->max_bookings <= $currentMaxBookings) {
                $this->processOnErrorTables($key, $table->id, 'over max bookings on date', $availableTables, $errors);
                continue;
            }

            if ($isCheckingOnArea) {
                $currentMaxGuests = $currentBookingsNumber[$table->area_id]['guests'] + $validateRules[$openingTime->id]['current_guests'];
            } else {
                $currentMaxGuests = $totalGuests + $validateRules[$openingTime->id]['current_guests'];
            }

            if ($bookingRule->max_guests <= $currentMaxGuests) {
                $this->processOnErrorTables($key, $table->id, 'over max guests on date', $availableTables, $errors);
                continue;
            }
            $validateRules[$openingTime->id]['current_guests'] += $table->max_guests;

            if ($bookingRule->prepayment != 'not_required') {
                if (empty($prepaymentAmountAttribute)) {
                    $this->processOnErrorTables($key, $table->id, 'prepayment required', $availableTables, $errors);
                    continue;
                }

                $minPrepaymentAmount = $bookingRule->prepayment_amount;
                if ($bookingRule->prepayment == 'per_guest') {
                    $guestsNumber = $guestsNumberAttribute < $bookingRule->prepayment_min_guests ?
                        $bookingRule->prepayment_min_guests : $guestsNumberAttribute;
                    $minPrepaymentAmount = $bookingRule->prepayment_amount * $guestsNumber;
                }
                if ($minPrepaymentAmount > $prepaymentAmountAttribute) {
                    $this->processOnErrorTables(
                        $key,
                        $table->id,
                        'minimum prepayment amount is ' . $bookingRule->prepayment_amount,
                        $availableTables,
                        $errors
                    );
                    continue;
                }
            }

            $bookingDate = new DateTime($bookingDateAttribute . 'T' . $bookingTimeAttribute);
            $maxLeadDate = new DateTime(date('Y-m-d H:i:s', strtotime('+' . $bookingRule->maximum_lead_time . ' hours')));
            $minLeadDate = new DateTime(date('Y-m-d H:i:s', strtotime('+' . $bookingRule->minimum_lead_time . ' hours')));
            if ($bookingDate < $minLeadDate || $bookingDate > $maxLeadDate) {
                $this->processOnErrorTables(
                    $key,
                    $table->id,
                    'booking on out of lead date',
                    $availableTables,
                    $errors
                );
                continue;
            }
        }

        return [
            'available_tables' => $availableTables,
            'errors' => $errors
        ];
    }

    private function isTablesAvailable(
        $businessId,
        array $ids,
        $onDate,
        $onTime,
        $duration,
        $guestsNumber,
        $prepaymentAmount
    ) {
        $tables = $this->tableRepo->getTablesByIds($businessId, $ids);

        // there some tables is not same business
        if (count($tables) != count($ids)) {
            return false;
        }

        $validatedData = $this->checkBookingRules(
            $businessId,
            $onDate,
            $onTime,
            $duration,
            $prepaymentAmount,
            $guestsNumber,
            $tables
        );
        if (count($validatedData['available_tables']) != count($tables)) {
            return false;
        }

        return $tables->toArray();
    }
}
