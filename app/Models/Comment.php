<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;
use App\Traits\Enums;

class Comment extends Model
{
    use Uuids;
    use Enums;
    use HasFactory;

    protected $guarded = [];
    protected $enumStatuses = [
        'unread',
        'readed',
        'replied'
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
