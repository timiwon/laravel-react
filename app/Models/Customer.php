<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;

class Customer extends Model
{
    use Uuids;
    use HasFactory;

    protected $guarded = [];
    protected $fillable = ['name'];

    public function customDomain()
    {
        return $this->morphOne(CustomDomain::class, 'reference');
    }

    public function businesses()
    {
        return $this->hasMany(Business::class);
    }
}
