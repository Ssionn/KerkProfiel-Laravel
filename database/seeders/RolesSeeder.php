<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Nejcc\PhpDatatypes\Composite\Dictionary;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    private readonly Dictionary $rolesWithPermissions;

    public function __construct()
    {
        $this->rolesWithPermissions = dictionary(config('custom-permission.roles'));
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
        return Role::firstOrCreate(['name' => $roleName]);
    }

    private function assignPermissionsToRole(array $permissions, Role $roleCreated): void
    {
        foreach ($permissions as $permissionName) {
            $permission = Permission::firstOrCreate(['name' => $permissionName]);

            $roleCreated->givePermissionTo($permission);
        }
    }
}
