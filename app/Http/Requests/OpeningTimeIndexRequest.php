<?php

namespace App\Http\Requests;

use App\Models\OpeningTime;

class OpeningTimeIndexRequest extends BaseRequest
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
            'reference_type' => ['nullable', 'in:area,business'],
            'reference_id' => [
                'nullable',
                'required_with:reference_type'
            ],
            'action' => ['in:' . implode(',', OpeningTime::getEnum('action'))],
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
            'action' => 'action ('.implode(',', OpeningTime::getEnum('action')).')',
            'reference_type' => 'reference_type (area,business)',
        ];
    }
}
