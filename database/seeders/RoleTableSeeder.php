<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleTableSeeder extends Seeder
{
    public function run(): void
    {
        // Create roles
        $admin = Role::firstOrCreate(['name' => 'Admin']);
        $researcher = Role::firstOrCreate(['name' => 'Researcher']);
        $reviewer = Role::firstOrCreate(['name' => 'Reviewer']);
        $user = Role::firstOrCreate(['name' => 'User']);

        // Assign permissions to roles
        $admin->syncPermissions(Permission::all());

        $researcher->syncPermissions([
            'upload-publication',
            'edit-publication',
            'delete-publication',
            'view-own-publication',
            'track-submission',
            'view-feedback',
            'manage-profile',
        ]);

        $reviewer->syncPermissions([
            'view-assigned-papers',
            'give-review',
            'accept-paper',
            'reject-paper',
        ]);

        $user->syncPermissions([
            'search-publications',
            'download-publication',
            'add-favorite',
            'remove-favorite',
            'view-open-access',
        ]);
    }
}
