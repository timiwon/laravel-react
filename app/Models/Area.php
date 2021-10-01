<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;
use App\Traits\Enums;

class Area extends Model
{
    use Uuids;
    use Enums;
    use HasFactory;

    protected $guarded = [];
    protected $enumStatuses = [
        'available',
        'unavailable'
    ];

    public function business() {
        return $this->belongsTo(Business::class);
    }

    public function tables() {
        return $this->hasMany(Table::class);
    }

    public function openingTimes() {
        return $this->hasMany(OpeningTime::class);
    }
}
