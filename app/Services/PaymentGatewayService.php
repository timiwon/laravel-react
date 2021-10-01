<?php

namespace App\Services;

use App\Http\Resources\BaseResource;
use App\Repositories\PaymentGatewayRepository;
use App\Repositories\BusinessRepository;

class PaymentGatewayService extends BaseService
{
    protected $businessRepo;

    public function __construct(
        PaymentGatewayRepository $repo,
        BusinessRepository $businessRepo
    ) {
        $this->businessRepo = $businessRepo;
        parent::__construct($repo);
    }

    public function createOnBusiness(string $businessId, array $attributes)
    {
        $business = $this->businessRepo->find($businessId);
        return new BaseResource($business->paymentGateways()->create($attributes));
    }

    public function updateOnBusiness(array $attributes, string $businessId, string $paymentGatewayId)
    {
        $paymentGateway = $this->repo->findWithReference($paymentGatewayId, 'business_id', $businessId);
        $paymentGateway->fill($attributes);
        $paymentGateway->save();
        return new BaseResource($paymentGateway);
    }
}
