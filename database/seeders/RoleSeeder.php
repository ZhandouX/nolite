<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roleAdmin = Role::findOrCreate('admin');
        $roleCustomer = Role::findOrCreate('customer');

        $userAdmin = User::firstOrCreate(
            ['email' => 'winboydev25@gmail.com'],
            [
                'name' => 'Admin Toko',
                'password' => Hash::make('password'),
            ]
        );
        $userAdmin->assignRole($roleAdmin);

        $userCustomer = User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => Hash::make('password'),
            ]
        );
        $userCustomer->assignRole($roleCustomer);
    }
}
