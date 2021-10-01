<?php

namespace App\Http\Requests;

use App\Models\PaymentGateway;

class PaymentGatewayStoreRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'type' => [
                'required',
                'in:' . implode(',', PaymentGateway::getEnum('type'))
            ],
            'configuration' => 'required'
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
            'type' => 'type ('.implode(',', PaymentGateway::getEnum('type')).')',
        ];
    }
}
