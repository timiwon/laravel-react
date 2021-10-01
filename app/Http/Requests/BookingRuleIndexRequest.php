<?php

namespace App\Http\Requests;

use App\Models\Area;

class BookingRuleIndexRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'page' => ['nullable', 'integer'],
            'per_page' => ['nullable', 'integer'],
            'is_count_online' => ['nullable', 'boolean']
        ];
    }
}
