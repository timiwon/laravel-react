<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;
use App\Traits\Enums;

class Table extends Model
{
    use Uuids, Enums;
    use HasFactory;

    protected $guarded = [];
    protected $casts = [
        'is_available_online' => 'boolean'
    ];

    protected $enumStatuses = [
        'on',
        'off'
    ];

    protected $enumTypes = [
        'single',
        'combination'
    ];

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function combinations()
    {
        return $this->belongsToMany(Table::class, 'table_combinations', 'table_id', 'combined_table_id');
    }

    public function beCombinations()
    {
        return $this->belongsToMany(Table::class, 'table_combinations', 'combined_table_id', 'table_id');
    }

    public function bookings()
    {
        return $this->belongsToMany(Booking::class, 'tables_has_bookings');
    }
}
