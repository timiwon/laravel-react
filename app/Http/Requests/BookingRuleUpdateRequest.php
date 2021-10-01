<?php

namespace App\Http\Requests;

use App\Models\BookingRule;

class BookingRuleUpdateRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'max_bookings' => ['required', 'integer'],
            'max_bookings_interval' => ['required', 'integer'],
            'max_guests' => ['required', 'integer'],
            'max_guests_interval' => ['required', 'integer'],
            'is_count_online' => ['required', 'boolean'],
            'time_interval' => ['required', 'date_format:H:i'],
            'duration' => ['required', 'date_format:H:i'],
            'prepayment' => ['required', 'in:' . implode(',', BookingRule::getEnum('prepayment'))],
            'prepayment_amount' => [
                'nullable',
                'integer',
                'required_unless:prepayment,not_required'
            ],
            'prepayment_min_guest' => [
                'nullable',
                'integer',
                'required_with:prepayment_amount'
            ],
            'cancel_before' => ['nullable', 'integer'],
            'maximum_lead_time' => ['required', 'integer'],
            'minimum_lead_time' => ['required', 'integer']
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
            'prepayment' => 'prepayment ('.implode(',', BookingRule::getEnum('prepayment')).')',
        ];
    }
}
