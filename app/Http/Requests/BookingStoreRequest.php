<?php

namespace App\Http\Requests;

use App\Models\Booking;

class BookingStoreRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'table_ids' => ['nullable', 'array'],
            'business_id' => ['required'],
            'booking_date' => ['required', 'date_format:Y-m-d'],
            'booking_time' => ['required', 'date_format:H:i'],
            'guests_number' => ['required', 'integer', 'min:1'],
            'duration' => ['required', 'date_format:H:i'],
            'prepayment_amount' => ['nullable', 'integer'],
            'cus_fb_id' => ['nullable'],
            'cus_email' => ['required', 'email'],
            'cus_name' => ['required'],
            'cus_phone' => ['nullable'],
            'transaction_id' => ['nullable']
        ];
    }
}
