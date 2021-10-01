<?php

namespace App\Http\Requests;

use App\Models\Area;

class AreaStoreRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'status' => [
                'required',
                'in:' . implode(',', Area::getEnum('status'))
            ],
            'name' => 'required',
            'priority' => ['required', 'integer']
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'status' => 'status ('.implode(',', Area::getEnum('status')).')',
        ];
    }
}
