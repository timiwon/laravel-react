<?php

namespace App\Repositories;

use App\Models\BookingRule;

class BookingRuleRepository extends BaseRepository
{
    public function __construct(BookingRule $model)
    {
        $filterAttributes = [
            'is_count_online',
        ];
        parent::__construct($model, $filterAttributes);
    }
}
