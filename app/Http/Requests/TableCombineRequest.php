<?php

namespace App\Http\Requests;

use App\Models\Table;

class TableCombineRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'table_ids' => ['required', 'array'],
        ];
    }
}
