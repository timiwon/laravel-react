<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookingStoreRequest;
use App\Http\Requests\BookingCustomerCallRequest;
use App\Http\Requests\BookingIndexRequest;
use App\Http\Requests\BookingUpdateRequest;
use App\Http\Requests\BookingGetAvailableTablesRequest;
use App\Http\Requests\BookingGetAvailableGuestsNumberRequest;
use App\Http\Requests\BookingGetAvailableTimeIntervalRequest;
use App\Services\BookingService;
use App\Models\Booking;

class BookingController extends Controller
{
    protected $service;

    public function __construct(BookingService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(BookingIndexRequest $request)
    {
        $this->authorize('viewAny', [Booking::class]);

        $params = $request->validated();
        return $this->service->getBookingsOnTables($params, $params['per_page'] ?? 10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\BookingStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(BookingStoreRequest $request)
    {
        $this->authorize('create', [Booking::class]);
        $validatedParams = $request->validated();
        $tableIds = $validatedParams['table_ids'] ?? [];
        $businessId = $validatedParams['business_id'];
        unset($validatedParams['business_id']);
        unset($validatedParams['table_ids']);
        return $this->service->createBooking($businessId, $tableIds, $validatedParams);
    }

    public function bookingOnline(BookingCustomerCallRequest $request)
    {
        $this->authorize('create', [Booking::class]);
        $validatedParams = $request->validated();
        $businessId = $validatedParams['business_id'];
        unset($validatedParams['business_id']);
        return $this->service->createBooking($businessId, [], $validatedParams);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(string $bookingId)
    {
        $this->authorize('view', [Booking::class, $bookingId]);
        return $this->service->find($bookingId);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\BookingUpdateRequest $request
     * @return \Illuminate\Http\Response
     */
    public function update(
        BookingUpdateRequest $request,
        string $bookingId,
    ) {
        $this->authorize('update', [Booking::class, $bookingId]);
        $attributes = $request->validated();
        return $this->service->updateBooking(
            $bookingId,
            $attributes
        );
    }

    public function getAvailableTables(BookingGetAvailableTablesRequest $request)
    {
        $this->authorize('getAvailableTables', [Booking::class]);

        $params = $request->validated();
        return $this->service->getAvailableTablesForBooking(
            $params['business_id'],
            null,
            $params['on_date'],
            $params['on_time'],
            $params['duration'],
            $params['guests_number'],
            $params['prepayment_amount'] ?? 0
        );
    }

    public function getAvailableGuestsNumber(BookingGetAvailableGuestsNumberRequest $request)
    {
        $params = $request->validated();
        return $this->service->getAvailableGuestsNumber($params['business_id']);
    }

    public function getAvailableTimeInterval(BookingGetAvailableTimeIntervalRequest $request)
    {
        $params = $request->validated();
        return $this->service->getAvailableTimesForBooking($params['business_id'], $params['booking_date']);
    }
}
