<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    private readonly array $rolesWithPermissions;

    private readonly array $users;

    public function __construct()
    {
        $this->rolesWithPermissions = config('custom-permission.roles');
        $this->users = config('users.user_emails');
    }

    public function run(): void
    {
        $roleMap = [];

        foreach ($this->rolesWithPermissions as $role => $permissions) {
            $roleCreated = $this->createRole($role);
            $this->assignPermissionsToRole($permissions, $roleCreated);
            $roleMap[$role] = $roleCreated->id;
        }

        $this->assignRoleToUser($roleMap);
    }

    private function createRole(string $roleName): Role
    {
        return Role::firstOrCreate(['name' => $roleName], ['team_id' => null]);
    }

    private function assignPermissionsToRole(array $permissions, Role $roleCreated): void
    {
        $permissionIds = [];

        foreach ($permissions as $permissionName) {
            $permission = Permission::firstOrCreate(['permission_name' => $permissionName]);
            $permissionIds[] = $permission->id;
        }

        $roleCreated->permissions()->sync($permissionIds);
    }

    private function assignRoleToUser(array $roleMap): void
    {
        foreach ($this->users as $username => $userConfig) {
            $roleId = $userConfig['role'] === 'teamleader'
                ? $roleMap['teamleader']
                : $roleMap[$userConfig['role']];

            User::where('email', $userConfig['email'])
                ->update(['role_id' => $roleId]);
        }
    }
}
