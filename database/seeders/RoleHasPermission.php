<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleHasPermission extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = Role::get();
        $permission =  Permission::get();
        $adminRole = $role->where('name', 'admin')->first();
        $adminPermission = $permission->where('portal', 'admin')->pluck('id')->toArray();

        $userRole = $role->where('name', 'user')->first();
        $userPermission = $permission->where('portal', 'user')->pluck('id')->toArray();

        $adminRole->syncPermissions($adminPermission);
        $userRole->syncPermissions($userPermission);
    }
}
