<?php

namespace App\Http\Requests;

class BookingGetAvailableGuestsNumberRequest extends BaseRequest
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
        ];
    }
}
