<?php

namespace App\Repositories;

use App\Models\CustomDomain;

class CustomDomainRepository extends BaseRepository
{
    public function __construct(CustomDomain $model)
    {
        $filterAttributes = [
            'reference_type',
            'reference_id',
        ];
        parent::__construct($model, $filterAttributes);
    }
}
