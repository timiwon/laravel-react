<?php

namespace App\Http\Requests;

class OpeningTimeAssignToRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'type' => ['required', 'in:area,business'],
            'id' => 'required'
        ];
    }

    public function attributes()
    {
        return [
            'type' => 'type (area,business)',
        ];
    }
}
