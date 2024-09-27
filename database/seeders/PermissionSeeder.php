<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            [
                'portal' => 'admin',
                'group_name' => 'admin-dashboard',
                'permissions' => [
                    'admin.dashboard',
                ]
            ],
            [
                'portal' => 'admin',
                'group_name' => 'admin-user',
                'permissions' => [
                    // admin Permissions
                    'admin.user.create',
                    'admin.user.view',
                    'admin.user.edit',
                    'admin.user.delete',
                ]
            ],
            [
                'portal' => 'admin',
                'group_name' => 'admin-post',
                'permissions' => [
                    'admin.post.create',
                    'admin.post.view',
                    'admin.post.edit',
                    'admin.post.delete',
                ]
            ],[
                'portal' => 'admin',
                'group_name' => 'admin-comment',
                'permissions' => [
                    'admin.comment.create',
                    'admin.comment.view',
                    'admin.comment.edit',
                    'admin.comment.delete',
                ]
            ],
            [
                'portal' => 'user',
                'group_name' => 'post',
                'permissions' => [
                    'user.post.create',
                    'user.post.view',
                    'user.post.edit',
                    'user.post.delete',
                ]
            ],
            [
                'portal' => 'user',
                'group_name' => 'comment',
                'permissions' => [
                    'user.comment.create',
                    'user.comment.view',
                    'user.comment.edit',
                    'user.comment.delete',
                ]
            ],
            [
                'portal' => 'user',
                'group_name' => 'profile',
                'permissions' => [
                    'user.profile.view',
                    'user.profile.edit',
                    'user.profile.delete',
                ]
            ]
        ];

        for ($i = 0; $i < count($permissions); $i++) {
            $permissionGroup = $permissions[$i]['group_name'];
            $permissionPortal = $permissions[$i]['portal'];
            for ($j = 0; $j < count($permissions[$i]['permissions']); $j++) {
                // Create Permission
                $permission = Permission::create(['name' => $permissions[$i]['permissions'][$j],'portal' => $permissionPortal, 'group_name' => $permissionGroup, 'guard_name' => 'web']);

            }
        }

    }
}
