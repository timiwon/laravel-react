<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;

class Permission extends Model
{
    use Uuids;
    use HasFactory;

    protected $guarded = [];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'roles_has_permissions');
    }
}
