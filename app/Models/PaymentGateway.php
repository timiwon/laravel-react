<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;
use App\Traits\Enums;

class PaymentGateway extends Model
{
    use Uuids;
    use Enums;
    use HasFactory;

    protected $guarded = [];
    protected $enumTypes = [
        'swish',
        'other'
    ];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }
}
