<?php

namespace App\Http\Requests;

use App\Models\Table;

class TableStoreRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'status' => ['required', 'in:' . implode(',', Table::getEnum('status'))],
            'type' => ['required', 'in:' . implode(',', Table::getEnum('type'))],
            'is_available_online' => ['required', 'boolean'],
            'name' => ['required'],
            'priority' => ['required', 'integer'],
            'min_guests' => ['required', 'integer'],
            'max_guests' => ['required', 'integer']
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
