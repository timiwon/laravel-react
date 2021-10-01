<?php

namespace App\Http\Controllers;

use App\Http\Requests\BusinessStoreRequest;
use App\Http\Requests\BusinessIndexRequest;
use App\Http\Requests\BusinessUpdateRequest;
use App\Http\Requests\BusinessAssignToCustomerRequest;
use App\Services\BusinessService;
use App\Models\Business;

class BusinessController extends Controller
{
    protected $service;

    public function __construct(BusinessService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(BusinessIndexRequest $request, string $customerId)
    {
        $this->authorize('viewAny', [Business::class, $customerId]);
        $params = $request->validated();
        $params['customer_id'] = $customerId;
        return $this->service->list($params, $params['per_page'] ?? 10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\BusinessStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(BusinessStoreRequest $request, string $customerId)
    {
        $this->authorize('create', [Business::class, $customerId]);
        $attributes = $request->validated();
        return $this->service->createOnCustomer($customerId, $attributes);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(string $customerId, string $businessId)
    {
        $this->authorize('view', [Business::class, $customerId, $businessId]);
        return $this->service->findWithReference($businessId, 'customer_id', $customerId);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\BusinessUpdateRequest $request
     * @return \Illuminate\Http\Response
     */
    public function update(
        BusinessUpdateRequest $request,
        string $customerId,
        string $businessId
    ) {
        $this->authorize('update', [Business::class, $customerId, $businessId]);
        $attributes = $request->validated();
        return $this->service->updateOnCustomer(
            $attributes,
            $customerId,
            $businessId
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(string $customerId, string $businessId)
    {
        $this->authorize('delete', [Business::class, $customerId, $businessId]);
        $this->service->deleteWithReferenceValidation($businessId, 'customer_id', $customerId);
    }

    public function assignToCustomer(
        BusinessAssignToCustomerRequest $request,
        string $customerId,
        string $businessId
    ) {
        $attributes = $request->validated();
        $this->authorize('assignToCustomer', [Business::class, $customerId, $businessId, $attributes['customer_id']]);

        return $this->service->assignToCustomer(
            $businessId,
            $customerId,
            $attributes['customer_id']
        );
    }
}
