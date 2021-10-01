<?php

namespace App\Http\Requests;

use App\Models\Table;

class TableIndexRequest extends BaseRequest
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
            'status' => ['nullable', 'in:' . implode(',', Table::getEnum('status'))],
            'type' => ['nullable', 'in:' . implode(',', Table::getEnum('type'))],
            'is_available_online' => ['nullable', 'boolean'],
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
            'status' => 'status ('.implode(',', Table::getEnum('status')).')',
            'type' => 'type ('.implode(',', Table::getEnum('type')).')',
        ];
    }
}
