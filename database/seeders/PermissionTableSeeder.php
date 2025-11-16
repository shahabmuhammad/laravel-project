<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            //  Admin 
             'role-list',
           'role-create',
           'role-edit',
           'role-delete',
            'user-list',
            'user-create',
            'user-edit',
            'user-delete',
            'view-analytics',
            'approve-research',
            'reject-research',
            'manage-categories',
            'system-settings',

            //  Researcher 
            'upload-publication',
            'edit-publication',
            'delete-publication',
            'view-own-publication',
            'track-submission',
            'view-feedback',
            'manage-profile',

            //  Reviewer 
            'view-assigned-papers',
            'give-review',
            'accept-paper',
            'reject-paper',

            //  User 
            'search-publications',
            'download-publication',
            'add-favorite',
            'remove-favorite',
            'view-open-access',

            // ====== Advanced ======
            'chatbot-access',
            'multilingual-access',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
    }
}
