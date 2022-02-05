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
            'Show-Admin',
            'Update-Admin',
            'Add-Admin',
            'Delete-Admin',
            'Show-User',
            'Update-User',
            'Delete-User',
            'Add-User',
            'Show-Category',
            'Update-Category',
            'Delete-Category',
            'Add-Category',
            'Show-City',
            'Update-City',
            'Delete-City',
            'Add-City',
        ];

        foreach ($permissions as $permission) {
            Permission::create([
                'name' => $permission
            ]);
        }
    }
}
