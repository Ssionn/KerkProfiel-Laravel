<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Permission extends Model
{
    protected $fillable = [
        'permission_name',
    ];

    public function roles(): HasMany
    {
        return $this->hasMany(Role::class);
    }
}
