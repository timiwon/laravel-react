<?php

namespace App\Http\Requests;

use App\Models\Comment;

class CommentStoreRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'content' => ['required'],
            'booking_id' => ['required']
        ];
    }
}
