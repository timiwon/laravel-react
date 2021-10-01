<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Builder;
use App\Models\Booking;

class BookingRepository extends BaseRepository
{
    public function __construct(Booking $model)
    {
        $filterAttributes = [
            'status',
            'booking_date',
            'table_id',
        ];
        parent::__construct($model, $filterAttributes);
    }

    public function getBookingsOnTables($tableId, $bookingDate, $perPage, $status=null) {
        $query = $this->model->whereHas(
            'tables',
            function (Builder $query) use ($tableId) {
                $query->where('id', $tableId);
            }
        )->where('booking_date', $bookingDate);

        if ($status) {
            $query = $query->where('status', $status);
        }

        return $query->paginate($perPage);
    }

    public function getAllBookingsOnSpecialTablesAtSpecialDate(array $tableIds, $bookingDate) {
        return $this->model->whereHas(
            'tables',
            function (Builder $query) use ($tableIds) {
                $query->whereIn('id', $tableIds);
            }
        )->whereIn('status', ['pending', 'accepted', 'seated', 'completed'])
            ->where('booking_date', $bookingDate)
            ->get();
    }

    public function getAvailableBookingsOnSpecialTablesAtSpecialRangeTime(
        array $tableIds,
        $bookingDate,
        $onTime,
        $leaveTime
    ) {
        return $this->model->whereHas(
            'tables',
            function (Builder $query) use ($tableIds) {
                $query->whereIn('id', $tableIds);
            }
        )->whereIn('status', ['pending', 'accepted', 'seated'])
            ->where('booking_date', $bookingDate)
            ->where('booking_time', '>', $onTime)
            ->where('booking_time', '<', $leaveTime)
            ->get();
    }
}
