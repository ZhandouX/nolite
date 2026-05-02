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
        // Buat roles
        $roleAdmin = Role::create(['name' => 'admin']);
        $roleCustomer = Role::create(['name' => 'customer']);

        // Buat akun Admin
        $userAdmin = User::create([
            'name' => 'Admin Toko',
            'email' => 'winboydev25@gmail.com',
            'password' => Hash::make('password'),
        ]);
        $userAdmin->assignRole($roleAdmin);

        // Buat akun Customer
        $userCustomer = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);
        $userCustomer->assignRole($roleCustomer);
    }
}
