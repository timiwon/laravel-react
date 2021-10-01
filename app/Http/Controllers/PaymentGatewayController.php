<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentGatewayIndexRequest;
use App\Http\Requests\PaymentGatewayStoreRequest;
use App\Http\Requests\PaymentGatewayUpdateRequest;
use App\Services\PaymentGatewayService;
use App\Models\PaymentGateway;

class PaymentGatewayController extends Controller
{
    protected $service;

    public function __construct(PaymentGatewayService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(PaymentGatewayIndexRequest $request, string $businessId)
    {
        $this->authorize('viewAny', [PaymentGateway::class, $businessId]);
        $params = $request->validated();
        $params['business_id'] = $businessId;
        return $this->service->list($params, $validated['per_page'] ?? 10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(PaymentGatewayStoreRequest $request, string $businessId)
    {
        $this->authorize('create', [PaymentGateway::class, $businessId]);
        $attributes = $request->validated();
        return $this->service->createOnBusiness($businessId, $attributes);
    }

    /**
     * Display the specified resource.
     *
     * @param  string $businessId
     * @param  string $paymentGatewayId
     * @return \Illuminate\Http\Response
     */
    public function show(string $businessId, string $paymentGatewayId)
    {
        $this->authorize('view', [PaymentGateway::class, $businessId, $paymentGatewayId]);
        return $this->service->findWithReference($paymentGatewayId, 'business_id', $businessId);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  string $businessId
     * @param  string $paymentGatewayId
     * @return \Illuminate\Http\Response
     */
    public function update(
        PaymentGatewayUpdateRequest $request,
        string $businessId,
        string $paymentGatewayId
    ) {
        $this->authorize('update', [PaymentGateway::class, $businessId, $paymentGatewayId]);
        $attributes = $request->validated();
        return $this->service->updateOnBusiness(
            $attributes,
            $businessId,
            $paymentGatewayId
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string $businessId
     * @param  string $paymentGatewayId
     * @return \Illuminate\Http\Response
     */
    public function destroy(string $businessId, string $paymentGatewayId)
    {
        $this->authorize('delete', [PaymentGateway::class, $businessId, $paymentGatewayId]);
        $this->service->deleteWithReferenceValidation($paymentGatewayId, 'business_id', $businessId);
    }
}
