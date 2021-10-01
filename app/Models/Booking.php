<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;
use App\Traits\Enums;

class Booking extends Model
{
    use Uuids;
    use Enums;
    use HasFactory;

    protected $guarded = [];

    protected $enumStatuses = [
        'pending',
        'accepted',
        'seated',
        'completed',
        'cancelled',
        'failed',
        'deleted'
    ];

    public function tables()
    {
        return $this->belongsToMany(Table::class, 'tables_has_bookings');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
