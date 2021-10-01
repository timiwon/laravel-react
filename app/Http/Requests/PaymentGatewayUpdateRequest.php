<?php

namespace App\Http\Requests;

use App\Models\PaymentGateway;

class PaymentGatewayUpdateRequest extends BaseRequest
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

    public function attributes()
    {
        return [
            'type' => 'type ('.implode(',', PaymentGateway::getEnum('type')).')',
        ];
    }
}
