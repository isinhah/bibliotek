<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleAndUserSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $userRole = Role::firstOrCreate(['name' => 'user']);

        $admin = User::firstOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Administrador',
                'password' => bcrypt('123456'),
            ]
        );

        $admin->assignRole($adminRole);

        $user = User::firstOrCreate(
            ['email' => 'leitor@leitor.com'],
            [
                'name' => 'Leitor',
                'password' => bcrypt('123456'),
            ]
        );
        $user->assignRole($userRole);
    }
}
