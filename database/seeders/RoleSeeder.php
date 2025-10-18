<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Roles
        $roleAdmin = Role::create(['name' => 'admin']);
        $roleCustomer = Role::create(['name' => 'customer']);

        // Admin Account
        $userAdmin = User::create([
            'name' => 'Admin Toko',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
        ]);
        $userAdmin->assignRole($roleAdmin);
    }
}
