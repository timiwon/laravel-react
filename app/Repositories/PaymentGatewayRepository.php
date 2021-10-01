<?php

namespace App\Repositories;

use App\Models\PaymentGateway;

class PaymentGatewayRepository extends BaseRepository
{
    public function __construct(PaymentGateway $model)
    {
        $filterAttributes = [
            'type',
            'business_id',
        ];
        parent::__construct($model, $filterAttributes);
    }
}
