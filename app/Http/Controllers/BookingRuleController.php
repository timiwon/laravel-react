<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookingRuleIndexRequest;
use App\Http\Requests\BookingRuleStoreRequest;
use App\Http\Requests\BookingRuleUpdateRequest;
use App\Services\BookingRuleService;
use App\Models\BookingRule;

class BookingRuleController extends Controller
{
    protected $service;

    public function __construct(BookingRuleService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(BookingRuleIndexRequest $request, string $openingTimeId)
    {
        $this->authorize('viewAny', [BookingRule::class, $openingTimeId]);
        $params = $request->validated();
        $params['opening_time_id'] = $openingTimeId;
        return $this->service->list($params, $validated['per_page'] ?? 10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(BookingRuleStoreRequest $request, string $openingTimeId)
    {
        $this->authorize('create', [BookingRule::class, $openingTimeId]);
        $attributes = $request->validated();
        return $this->service->createOnOpeningTime($openingTimeId, $attributes);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(string $openingTimeId, string $bookingRuleId)
    {
        $this->authorize('view', [BookingRule::class, $openingTimeId, $bookingRuleId]);
        return $this->service->findWithReference($bookingRuleId, 'opening_time_id', $openingTimeId);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(
        BookingRuleUpdateRequest $request,
        string $openingTimeId,
        string $bookingRuleId
    ) {
        $this->authorize('update', [BookingRule::class, $openingTimeId, $bookingRuleId]);
        $attributes = $request->validated();
        return $this->service->updateOnOpeningTime(
            $attributes,
            $openingTimeId,
            $bookingRuleId
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(string $openingTimeId, string $bookingRuleId)
    {
        $this->authorize('delete', [BookingRule::class, $openingTimeId, $bookingRuleId]);
        $this->service->deleteWithReferenceValidation($bookingRuleId, 'opening_time_id', $openingTimeId);
    }
}
