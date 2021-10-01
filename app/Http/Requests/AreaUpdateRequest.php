<?php

namespace App\Http\Requests;

use App\Models\Area;

class AreaUpdateRequest extends BaseRequest
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
            'priority' => ['required', 'integer'],
        ];
    }

    public function attributes()
    {
        return [
            'status' => 'status ('.implode(',', Area::getEnum('status')).')',
        ];
    }
}
