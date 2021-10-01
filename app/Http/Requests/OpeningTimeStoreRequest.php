<?php

namespace App\Http\Requests;

use App\Models\OpeningTime;

class OpeningTimeStoreRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'action' => [
                'required',
                'in:' . implode(',', OpeningTime::getEnum('action'))
            ],
            'weekly_value' => [
                'nullable',
                'in:' . implode(',', OpeningTime::getEnum('weekly_value')),
                'required_without:from_date'
            ],
            'from_date' => [
                'nullable',
                'date',
                'required_without:weekly_value',
            ],
            'to_date' => [
                'nullable',
                'date',
                'required_with:from_date'
            ],
            'from_time' => ['required','date_format:H:i'],
            'to_time' => ['required', 'date_format:H:i'],
            'note' => 'nullable'
        ];
    }

    public function attributes()
    {
        return [
            'action' => 'action ('.implode(',', OpeningTime::getEnum('action')).')',
            'weekly_value' => 'weekly_value ('.implode(',', OpeningTime::getEnum('weekly_value')).')',
        ];
    }
}
