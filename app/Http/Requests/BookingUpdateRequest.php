<?php

namespace App\Http\Requests;

use App\Models\Booking;

class BookingUpdateRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'status' => ['required', 'in:' . implode(',', Booking::getEnum('status'))],
            'duration' => ['required', 'date_format:H:i'],
            'cus_email' => ['required', 'email'],
            'cus_name' => ['required'],
            'cus_phone' => ['required'],
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
