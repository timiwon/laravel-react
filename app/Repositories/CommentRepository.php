<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Builder;
use App\Models\Comment;

class CommentRepository extends BaseRepository
{
    public function __construct(Comment $model)
    {
        $filterAttributes = [
            'status',
            'booking_id',
        ];
        parent::__construct($model, $filterAttributes);
    }

    public function updateAllCommentStatusOnBooking($bookingId, $status) {
        return $this->model->where('booking_id', $bookingId)->update(['status' => $status]);
    }

    public function getAllWaitingCommentsOnArea($areaId) {
        return $this->model->whereHas(
            'booking',
            function (Builder $query) use ($areaId) {
                $query->whereHas(
                    'tables',
                    function (Builder $query) use ($areaId) {
                        $query->where('area_id', $areaId);
                    }
                )->where('status', ['pending', 'accepted']);
            }
        )->whereIn('status', ['unread', 'readed']);
    }
}
