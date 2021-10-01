<?php

namespace App\Services;

use App\Http\Resources\BaseResource;
use App\Repositories\CommentRepository;
use App\Repositories\BookingRepository;
use App\Repositories\AreaRepository;

class CommentService extends BaseService
{
    protected $bookingRepo;
    protected $areaRepo;

    public function __construct(
        CommentRepository $repo,
        BookingRepository $bookingRepo,
        AreaRepository $areaRepo
    ) {
        parent::__construct($repo);

        $this->bookingRepo = $bookingRepo;
        $this->areaRepo = $areaRepo;
    }

    public function listWaitingInArea($areaId, $perPage) {
        return BaseResource::collection(
            $this->repo->getAllWaitingCommentsOnArea($areaId, $perPage)->paginate($perPage)
        );
    }

    public function createOnBooking(string $bookingId, array $attributes, $userId=null)
    {
        $booking = $this->bookingRepo->find($bookingId);
        if (in_array($booking->status, ['completed', 'cancelled', 'deleted'])) {
            abort(400, 'can\'t comment when booking is '.$booking->status);
        }

        $attributes['status'] = 'unread';
        $comment = new BaseResource($booking->comments()->create($attributes));

        // when admin post a comment will update all comment to replied
        if ($userId) {
            $this->repo->updateAllCommentStatusOnBooking($bookingId, 'replied');
        }

        return $comment;
    }
}
