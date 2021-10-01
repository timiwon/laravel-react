<?php

namespace App\Repositories;

use App\Models\OpeningTime;

class OpeningTimeRepository extends BaseRepository
{
    public function __construct(OpeningTime $model)
    {
        $filterAttributes = [
            'action',
            'area_id',
            'business_id',
        ];
        parent::__construct($model, $filterAttributes);
    }

    public function getOnReferenceAtSpecialTime(
        $referenceType,
        $referenceId,
        $action,
        $bookingDate,
        $bookingTime=null
    ) {
        $query = $this->model->where('action', $action)
            ->where('from_date', '<=', $bookingDate)
            ->where('to_date', '>=', $bookingDate);

        if ($referenceType == 'area') {
            $query = $query->where('area_id', $referenceId);
        } else {
            $query = $query->where('business_id', $referenceId);
        }

        // case bookingTime null is used for getting available times for booking on special date
        if (!is_null($bookingTime)) {
            $query = $query->where('from_time', '<=', $bookingTime)
                ->where('to_time', '>=', $bookingTime);
        }

        return $query->first();
    }

    public function getOnReferenceAtWeekDay(
        $referenceType,
        $referenceId,
        $action,
        $bookingDate,
        $bookingTime=null
    ) {
        $dayOfWeek = ['sunday', 'monday', 'tuesday', 'wednesday','thursday','friday', 'saturday'];
        $query = $this->model->where('action', $action)
            ->where('weekly_value', $dayOfWeek[date('w', strtotime($bookingDate))]);

        if ($referenceType == 'area') {
            $query = $query->where('area_id', $referenceId);
        } else {
            $query = $query->where('business_id', $referenceId);
        }

        // case bookingTime null is used for getting available times for booking on special date
        if (!is_null($bookingTime)) {
            $query = $query->where('from_time', '<=', $bookingTime)
                ->where('to_time', '>=', $bookingTime);
        }

        return $query->first();
    }
}
