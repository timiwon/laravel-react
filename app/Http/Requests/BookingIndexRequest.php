<?php

namespace App\Http\Requests;

use App\Models\Booking;

class BookingIndexRequest extends BaseRequest
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
            'status' => ['nullable', 'in:' . implode(',', Booking::getEnum('status'))],
            'table_id' => ['required'],
            'booking_date' => ['required', 'date'],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'status' => 'status ('.implode(',', Booking::getEnum('status')).')',
        ];
    }
}
