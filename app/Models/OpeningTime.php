<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;
use App\Traits\Enums;

class OpeningTime extends Model
{
    use Uuids;
    use Enums;
    use HasFactory;

    protected $guarded = [];
    protected $enumActions = [
        'open',
        'close'
    ];
    protected $enumWeeklyValues = [
        'monday',
        'tuesday',
        'wedday',
        'thursday',
        'friday',
        'satday',
        'sunday'
    ];

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function bookingRule() {
        return $this->hasOne(BookingRule::class);
    }
}
