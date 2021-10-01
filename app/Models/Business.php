<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;
use App\Traits\Enums;

class Business extends Model
{
    use Uuids;
    use Enums;
    use HasFactory;

    protected $guarded = [];
    protected $fillable = [
        'type',
        'status',
        'name',
        'address',
        'phone',
        'url'
    ];

    protected $enumTypes = [
        'restaurant',
        'hotel'
    ];

    protected $enumStatuses = [
        'available',
        'unavailable'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function customDomain()
    {
        return $this->morphOne(CustomDomain::class, 'reference');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'roles_has_businesses');
    }

    public function paymentGateways()
    {
        return $this->hasMany(PaymentGateway::class);
    }

    public function areas()
    {
        return $this->hasMany(Area::class);
    }

    public function openingTimes() {
        return $this->hasMany(OpeningTime::class);
    }
}
