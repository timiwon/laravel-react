<?php

namespace App\Http\Requests;

use App\Models\PaymentGateway;

class PaymentGatewayIndexRequest extends BaseRequest
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
            'type' => ['in:' . implode(',', PaymentGateway::getEnum('type'))]
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
            'type' => 'type ('.implode(',', PaymentGateway::getEnum('type')).')',
        ];
    }
}
