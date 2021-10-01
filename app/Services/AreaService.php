<?php

namespace App\Services;

use App\Http\Resources\BaseResource;
use App\Repositories\AreaRepository;
use App\Repositories\BusinessRepository;

class AreaService extends BaseService
{
    protected $businessRepo;

    public function __construct(
        AreaRepository $repo,
        BusinessRepository $businessRepo
    ) {
        $this->businessRepo = $businessRepo;
        parent::__construct($repo);
    }

    public function createOnBusiness(string $businessId, array $attributes)
    {
        $business = $this->businessRepo->find($businessId);
        return new BaseResource($business->areas()->create($attributes));
    }

    public function updateOnBusiness(array $attributes, string $businessId, string $areaId)
    {
        $area = $this->repo->findWithReference($areaId, 'business_id', $businessId);
        $area->fill($attributes);
        $area->save();
        return new BaseResource($area);
    }
}
