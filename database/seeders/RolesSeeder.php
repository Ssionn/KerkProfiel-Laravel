<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    private array $rolesWithPermissions;

    public function __construct()
    {
        $this->rolesWithPermissions = config('custom-permission.roles');
    }

    public function run(): void
    {
        foreach ($this->rolesWithPermissions as $role => $permissions) {
            $roleCreated = $this->createRole($role);

            $this->assignPermissionsToRole($permissions, $roleCreated);
        }
    }

    private function createRole(string $roleName): Role
    {
        return Role::firstOrCreate(['name' => $roleName, 'team_id' => null]);
    }

    private function assignPermissionsToRole(array $permissions, Role $roleCreated): void
    {
        foreach ($permissions as $permissionName) {
            $permission = Permission::firstOrCreate(['name' => $permissionName]);

            $roleCreated->givePermissionTo($permission);
        }
    }
}
