<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;
use App\Traits\Enums;

class BookingRule extends Model
{
    use Uuids;
    use Enums;
    use HasFactory;

    protected $guarded = [];
    
    protected $enumPrepayments = [
        'per_guest',
        'per_booking',
        'not_required'
    ];

    public function opening_time()
    {
        return $this->belongsTo(OpeningTime::class);
    }
}
