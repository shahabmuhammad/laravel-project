<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class CreateAdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin ',
                'password' => bcrypt('admin@gmail.com'),
            ]
        );

        $role = Role::where('name', 'Admin')->first();
        if ($role) {
            $user->assignRole($role);
        }
    }
}
