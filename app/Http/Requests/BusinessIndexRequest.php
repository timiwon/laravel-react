<?php

namespace App\Http\Requests;

use App\Models\Business;

class BusinessIndexRequest extends BaseRequest
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
            'type' => ['in:' . implode(',', Business::getEnum('type'))],
            'status' => ['in:' . implode(',', Business::getEnum('status'))],
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
            'type' => 'type ('.implode(',', Business::getEnum('type')).')',
            'status' => 'status ('.implode(',', Business::getEnum('status')).')',
        ];
    }
}
