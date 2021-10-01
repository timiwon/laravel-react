<?php

namespace App\Http\Requests;

class BusinessUpdateRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'type' => 'required',
            'status' => 'required',
            'name' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'url' => 'nullable'
        ];
    }
}
