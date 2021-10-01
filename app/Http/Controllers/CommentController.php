<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentIndexRequest;
use App\Http\Requests\CommentGetListWaitingInAreaRequest;
use App\Http\Requests\CommentStoreRequest;
use App\Services\CommentService;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    protected $service;

    public function __construct(CommentService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(CommentIndexRequest $request)
    {
        $params = $request->validated();
        return $this->service->list($params, $params['per_page'] ?? 100);
    }

    public function getListWaitingInArea(CommentGetListWaitingInAreaRequest $request)
    {
        $params = $request->validated();
        $areaId = $params['area_id'];
        $this->authorize('viewListInArea', [Comment::class, $areaId]);

        return $this->service->listWaitingInArea($areaId, $validated['per_page'] ?? 10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CommentStoreRequest $request, User $user)
    {
        $attributes = $request->validated();
        $bookingId = $attributes['booking_id'];

        $this->authorize('create', [Comment::class, $bookingId]);
        return $this->service->createOnBooking($bookingId, $attributes, Auth::user()->id);
    }

    public function guestSend(CommentStoreRequest $request)
    {
        $attributes = $request->validated();
        $bookingId = $attributes['booking_id'];

        return $this->service->createOnBooking($bookingId, $attributes);
    }
}
