<?php

namespace App\Services;

use App\Http\Resources\BaseResource;
use App\Repositories\OpeningTimeRepository;

class OpeningTimeService extends BaseService
{
    public function __construct(
        OpeningTimeRepository $repo,
    ) {
        parent::__construct($repo);
    }

    public function assignTo(string $openingTimeId, string $referenceType, string $referenceId)
    {
        $openingTime = $this->repo->find($openingTimeId);
        if ($referenceType === 'business') {
            $openingTime->business()->associate($referenceId);
        } elseif ($referenceType === 'area') {
            $openingTime->area()->associate($referenceId);
        }
        $openingTime->save();
        return new BaseResource($openingTime);
    }
}
