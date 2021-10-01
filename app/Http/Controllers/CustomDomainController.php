<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomDomainStoreRequest;
use App\Http\Requests\CustomDomainIndexRequest;
use App\Http\Requests\CustomDomainUpdateRequest;
use App\Services\CustomDomainService;
use App\Models\CustomDomain;

class CustomDomainController extends Controller
{
    protected $service;

    public function __construct(CustomDomainService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(CustomDomainIndexRequest $request)
    {
        $this->authorize('viewAny', [CustomDomain::class]);

        $params = $request->validated();
        return $this->service->list($params, $params['per_page'] ?? 10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\CustomDomainStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CustomDomainStoreRequest $request)
    {
        $this->authorize('create', [CustomDomain::class]);
        return $this->service->createOnReference($request->validated());
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(string $id)
    {
        $this->authorize('view', [CustomDomain::class, $id]);
        return $this->service->find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\TableUpdateRequest $request
     * @return \Illuminate\Http\Response
     */
    public function update(
        CustomDomainUpdateRequest $request,
        string $id
    ) {
        $this->authorize('update', [CustomDomain::class, $id]);
        $attributes = $request->validated();
        return $this->service->update(
            $id,
            $attributes,
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(string $id)
    {
        $this->authorize('delete', [CustomDomain::class, $id]);
        $this->service->delete($id);
    }
}
