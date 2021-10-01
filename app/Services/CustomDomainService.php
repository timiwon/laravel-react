<?php

namespace App\Services;

use App\Http\Resources\BaseResource;
use App\Repositories\CustomDomainRepository;
use App\Repositories\BusinessRepository;
use App\Repositories\CustomerRepository;

class CustomDomainService extends BaseService
{
    protected $businessRepo;
    protected $customerRepo;

    public function __construct(
        CustomDomainRepository $repo,
        BusinessRepository $businessRepo,
        CustomerRepository $customerRepo
    ) {
        parent::__construct($repo);
        $this->businessRepo = $businessRepo;
        $this->customerRepo = $customerRepo;
    }

    public function createOnReference(array $attributes)
    {
        if ($attributes['reference_type'] == 'business') {
            // check business is exists
            $this->businessRepo->find($attributes['reference_id']);
        } else {
            // check customer is exists
            $this->customerRepo->find($attributes['reference_id']);
        }

        return new BaseResource($this->repo->create($attributes));
    }
}
