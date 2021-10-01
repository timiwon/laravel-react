<?php

namespace App\Http\Controllers;

use App\Http\Requests\AreaIndexRequest;
use App\Http\Requests\AreaStoreRequest;
use App\Http\Requests\AreaUpdateRequest;
use App\Services\AreaService;
use App\Models\Area;

class AreaController extends Controller
{
    protected $service;

    public function __construct(AreaService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(AreaIndexRequest $request, string $businessId)
    {
        $this->authorize('viewAny', [Area::class, $businessId]);
        $params = $request->validated();
        $params['business_id'] = $businessId;
        return $this->service->list($params, $validated['per_page'] ?? 10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(AreaStoreRequest $request, string $businessId)
    {
        $this->authorize('create', [Area::class, $businessId]);
        $attributes = $request->validated();
        return $this->service->createOnBusiness($businessId, $attributes);
    }

    /**
     * Display the specified resource.
     *
     * @param  string $businessId
     * @param  string $areaId
     * @return \Illuminate\Http\Response
     */
    public function show(string $businessId, string $areaId)
    {
        $this->authorize('view', [Area::class, $businessId, $areaId]);
        return $this->service->findWithReference($areaId, 'business_id', $businessId);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  string $businessId
     * @param  string $areaId
     * @return \Illuminate\Http\Response
     */
    public function update(
        AreaUpdateRequest $request,
        string $businessId,
        string $areaId
    ) {
        $this->authorize('update', [Area::class, $businessId, $areaId]);
        $attributes = $request->validated();
        return $this->service->updateOnBusiness(
            $attributes,
            $businessId,
            $areaId
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string $businessId
     * @param  string $areaId
     * @return \Illuminate\Http\Response
     */
    public function destroy(string $businessId, string $areaId)
    {
        $this->authorize('delete', [Area::class, $businessId, $areaId]);
        $this->service->deleteWithReferenceValidation($areaId, 'business_id', $businessId);
    }
}
