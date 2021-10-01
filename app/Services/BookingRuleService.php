<?php

namespace App\Services;

use App\Http\Resources\BaseResource;
use App\Repositories\BookingRuleRepository;
use App\Repositories\OpeningTimeRepository;

class BookingRuleService extends BaseService
{
    protected $openingTimeRepo;

    public function __construct(
        BookingRuleRepository $repo,
        OpeningTimeRepository $openingTimeRepo
    ) {
        $this->openingTimeRepo = $openingTimeRepo;
        parent::__construct($repo);
    }

    public function createOnOpeningTime(string $openingTimeId, array $attributes)
    {
        $openingTime = $this->openingTimeRepo->find($openingTimeId);
        return new BaseResource($openingTime->bookingRule()->create($attributes));
    }

    public function updateOnOpeningTime(array $attributes, string $openingTimeId, string $bookingRuleId)
    {
        $bookingRule = $this->repo->findWithReference($bookingRuleId, 'opening_time_id', $openingTimeId);
        $bookingRule->fill($attributes);
        $bookingRule->save();
        return new BaseResource($bookingRule);
    }
}
