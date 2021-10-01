<?php

namespace App\Http\Requests;

class CommentIndexRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'booking_id' => ['required'],
            'page' => ['nullable', 'integer'],
            'per_page' => ['nullable', 'integer'],
        ];
    }
}
