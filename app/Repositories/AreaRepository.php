<?php

namespace App\Repositories;

use App\Models\Area;

class AreaRepository extends BaseRepository
{
    public function __construct(Area $model)
    {
        $filterAttributes = [
            'status',
            'business_id',
        ];
        parent::__construct($model, $filterAttributes);
    }
}
