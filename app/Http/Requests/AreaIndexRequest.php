<?php

namespace App\Http\Requests;

use App\Models\Area;

class AreaIndexRequest extends BaseRequest
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
            'status' => ['in:' . implode(',', Area::getEnum('status'))]
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
            'status' => 'status ('.implode(',', Area::getEnum('status')).')',
        ];
    }
}
