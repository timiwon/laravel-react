<?php

namespace App\Http\Controllers;

use App\Http\Requests\OpeningTimeStoreRequest;
use App\Http\Requests\OpeningTimeIndexRequest;
use App\Http\Requests\OpeningTimeUpdateRequest;
use App\Http\Requests\OpeningTimeAssignToRequest;
use App\Services\OpeningTimeService;
use App\Models\OpeningTime;

class OpeningTimeController extends Controller
{
    protected $service;

    public function __construct(OpeningTimeService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(OpeningTimeIndexRequest $request)
    {
        $this->authorize('viewAny', [OpeningTime::class]);

        $params = $request->validated();
        if (array_key_exists('reference_type', $params)) {
            $referenceKey = $params['reference_type'] . '_id';
            $params[$referenceKey] = $params['reference_id'];
        }
        return $this->service->list($params, $params['per_page'] ?? 10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\OpeningTimeStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(OpeningTimeStoreRequest $request)
    {
        $this->authorize('create', [OpeningTime::class]);
        return $this->service->create($request->validated());
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(string $openingTimeId)
    {
        $this->authorize('view', [OpeningTime::class, $openingTimeId]);
        return $this->service->find($openingTimeId);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\OpeningTimeUpdateRequest $request
     * @return \Illuminate\Http\Response
     */
    public function update(
        OpeningTimeUpdateRequest $request,
        string $openingTimeId,
    ) {
        $this->authorize('update', [OpeningTime::class, $openingTimeId]);
        $attributes = $request->validated();
        return $this->service->update($openingTimeId, $attributes);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(string $openingTimeId)
    {
        $this->authorize('delete', [OpeningTime::class, $openingTimeId]);
        $this->service->delete($openingTimeId);
    }

    public function assignTo(
        OpeningTimeAssignToRequest $request,
        string $openingTimeId,
    ) {
        $attributes = $request->validated();
        $this->authorize('assignTo', [OpeningTime::class, $openingTimeId, $attributes['type'], $attributes['id']]);
        return $this->service->assignTo(
            $openingTimeId,
            $attributes['type'],
            $attributes['id']
        );
    }
}
