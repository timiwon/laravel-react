<?php

namespace App\Http\Requests;

use App\Models\CustomDomain;

class CustomDomainUpdateRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'domain' => ['required', 'url']
        ];
    }
}
