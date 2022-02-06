<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        $permissions = [
            'Admin-Item',
            'Show-Admin',
            'Update-Admin',
            'Add-Admin',
            'Delete-Admin',
            'User-Item',
            'Show-User',
            'Update-User',
            'Delete-User',
            'Add-User',
            'Category-Item',
            'Show-Category',
            'Update-Category',
            'Delete-Category',
            'Add-Category',
            'City-Item',
            'Show-City',
            'Update-City',
            'Delete-City',
            'Add-City',
            'Role-Permission',
            'Task-Item',
            'Add-Task',
            'Update-Task',
            'Delete-Task',
            'Show-Task',
        ];

        $guards = [
            'admin',
            'user'
        ];

        foreach ($permissions as $permission) {
            foreach ($guards as $guard) {
                Permission::create([
                    'name' => $permission,
                    'guard_name' => $guard,
                ]);
            }
        }


    }
}
