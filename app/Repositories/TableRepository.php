<?php

namespace App\Repositories;

use DateTime;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Table;

class TableRepository extends BaseRepository
{
    public function __construct(Table $model)
    {
        $filterAttributes = [
            'status',
            'type',
            'is_available_online',
            'area_id',
        ];
        parent::__construct($model, $filterAttributes);
    }

    public function findWithCombinations(string $areaId, string $id) {
        $query['id'] = $id;
        $query['area_id'] = $areaId;
        return $this->model->where($query)
            ->with('combinations:id,status,is_available_online,name')
            ->with('beCombinations:id,status,is_available_online,name')
            ->firstOrFail();
    }

    public function isTablesInSameArea(string $areaId, array $tableIds) {
        $tables = $this->model->where('area_id', $areaId)
            ->whereIn('id', $tableIds)->get();

        if (count($tables) != count($tableIds)) {
            return false;
        }

        return true;
    }

    public function getBookedTables($businessId, $bookingDate, $bookingTime, $duration) {
        return $this->model->whereHas(
            'bookings',
            function (Builder $query) use ($bookingDate, $bookingTime, $duration) {
                $query->whereIn('status', ['pending', 'accepted', 'seated'])
                    ->where('booking_date', $bookingDate)
                    ->where('booking_time', '>=', date("H:i:s", strtotime($bookingTime)))
                    ->where('booking_time', '<=', date("H:i:s", strtotime($duration) + strtotime($bookingTime)));
            }
        )->whereHas('area', function (Builder $query) use ($businessId) {
            $query->where('business_id', $businessId);
        })->get();
    }

    public function getAllTablesInBusiness($businessId, $isAvailableOnline=null) {
        $query = $this->model->whereHas('area', function (Builder $query) use ($businessId) {
            $query->where('business_id', $businessId);
        });
        if ($isAvailableOnline) {
            $query = $query->where('is_available_online', $isAvailableOnline);
        }
        return $query->orderBy('priority', 'desc')->get();
    }

    public function getTablesByIds($businessId, array $ids) {
        return $this->model->whereHas('area', function (Builder $query) use ($businessId) {
                $query->where('business_id', $businessId);
            })->whereIn('id', $ids)->get();
    }

    public function getAllTablesInBusinessWithGuestsNumber(string $businessId, int $guestsNumber, $isAvailableOnline=null) {
        $query = $this->model->whereHas('area', function (Builder $query) use ($businessId) {
            $query->where('business_id', $businessId);
        })->where('min_guests', '<=', $guestsNumber)
            ->where('max_guests', '>=', $guestsNumber);

        if ($isAvailableOnline) {
            $query = $query->where('is_available_online', $isAvailableOnline);
        }
        return $query->orderBy('priority', 'desc')->get();
    }
}
