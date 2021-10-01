<?php

namespace App\Http\Requests;

class BookingGetAvailableTimeIntervalRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'business_id' => ['required'],
            'booking_date' => ['required', 'date'],
        ];
    }
}
