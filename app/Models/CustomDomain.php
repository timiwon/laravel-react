<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;
use App\Traits\Enums;

class CustomDomain extends Model
{
    use Uuids;
    use Enums;
    use HasFactory;

    protected $guarded = [];
    protected $enumReferenceTypes = [
        'customer',
        'business'
    ];

    public function reference()
    {
        return $this->morphTo();
    }
}
