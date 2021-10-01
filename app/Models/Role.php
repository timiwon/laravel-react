<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;

class Role extends Model
{
    use Uuids;
    use HasFactory;

    protected $guarded = [];

    public function users()
    {
        return $this->belongsToMany(User::class, 'users_has_roles');
    }

    public function businesses()
    {
        return $this->belongsToMany(Business::class, 'roles_has_businesses');
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'roles_has_permissions');
    }
}
