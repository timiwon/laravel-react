<?php

namespace App\Repositories;

use App\Models\Business;

class BusinessRepository extends BaseRepository
{
    public function __construct(Business $model)
    {
        $filterAttributes = [
            'type',
            'status',
            'customer_id',
        ];
        parent::__construct($model, $filterAttributes);
    }
}
