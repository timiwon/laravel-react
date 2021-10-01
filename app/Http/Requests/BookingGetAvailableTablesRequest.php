<?php

namespace App\Http\Requests;

use App\Models\Booking;

class BookingGetAvailableTablesRequest extends BaseRequest
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
            'on_date' => ['required', 'date'],
            'on_time' => ['required', 'date_format:H:i'],
            'duration' => ['required', 'date_format:H:i'],
            'guests_number' => ['required', 'integer', 'min:1'],
            'prepayment_amount' => ['nullable', 'integer'],
        ];
    }
}
