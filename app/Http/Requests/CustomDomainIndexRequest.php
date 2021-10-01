<?php

namespace App\Http\Requests;

use App\Models\CustomDomain;

class CustomDomainIndexRequest extends BaseRequest
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
            'reference_type' => ['required', 'in:' . implode(',', CustomDomain::getEnum('reference_type'))],
            'reference_id' => ['required'],
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
            'reference_type' => 'reference_type ('.implode(',', CustomDomain::getEnum('reference_type')).')',
        ];
    }
}
