<?php

namespace App\Repositories;

use App\Models\Role;

class RoleRepository
{
    public function findMemberRole(): Role
    {
        return Role::where('name', 'member')->first();
    }

    public function findPluckedIdFromRoleName(string $name): Role
    {
        return Role::where('name', $name)->pluck('id')->first();
    }
}
