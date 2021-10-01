<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerStoreRequest;
use App\Http\Requests\CustomerIndexRequest;
use App\Http\Requests\CustomerUpdateRequest;
use App\Services\CustomerService;
use App\Models\Customer;

class CustomerController extends Controller
{
    protected $service;

    public function __construct(CustomerService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(CustomerIndexRequest $request)
    {
        $this->authorize('viewAny', [Customer::class]);
        $validated = $request->validated();
        return $this->service->list($validated, $validated['per_page'] ?? 10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\StoreCustomerRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CustomerStoreRequest $request)
    {
        $this->authorize('create', [Customer::class]);
        $validated = $request->validated();
        return $this->service->create($validated);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(string $id)
    {
        $this->authorize('view', [Customer::class]);
        return $this->service->find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\StoreCustomerRequest $request
     * @return \Illuminate\Http\Response
     */
    public function update(CustomerUpdateRequest $request, string $id)
    {
        $this->authorize('update', [Customer::class]);
        $validated = $request->validated();
        return $this->service->update($id, $validated);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(string $id)
    {
        $this->authorize('delete', [Customer::class]);
        $this->service->delete($id);
    }
}
