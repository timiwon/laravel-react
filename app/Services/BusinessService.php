<?php

namespace App\Services;

use App\Http\Resources\BaseResource;
use App\Repositories\BusinessRepository;
use App\Repositories\CustomerRepository;

class BusinessService extends BaseService
{
    protected $customerRepo;

    public function __construct(
        BusinessRepository $repo,
        CustomerRepository $customerRepo
    ) {
        $this->customerRepo = $customerRepo;
        parent::__construct($repo);
    }

    public function createOnCustomer(string $customerId, array $attributes)
    {
        $customer = $this->customerRepo->find($customerId);
        return new BaseResource($customer->business()->create($attributes));
    }

    public function updateOnCustomer(array $attributes, string $customerId, string $businessId)
    {
        $business = $this->repo->findWithReference($businessId, 'customer_id', $customerId);
        $business->fill($attributes);
        $business->save();
        return new BaseResource($business);
    }

    public function assignToCustomer(string $businessId, string $oldCustomerId, string $newCustomerId)
    {
        $business = $this->repo->find($businessId);
        if ($business->customer_id != $oldCustomerId) {
            abort(404, 'business does not belong to customer');
        }

        $business->customer()->associate($newCustomerId);
        $business->save();
        return new BaseResource($business);
    }
}
