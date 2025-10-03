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
        // Membuat Role
        $roleAdmin = Role::create(['name' => 'admin']);
        $roleCustomer = Role::create(['name' => 'customer']);

        // Membuat Akun Admin
        $userAdmin = User::create([
            'name' => 'Admin Toko',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
        ]);

        // Berikan role admin ke akun admin
        $userAdmin->assignRole($roleAdmin);
        
        // Membuat Akun Customer
        $userCustomer = User::create([
            'name' => 'Pelanggan',
            'email' => 'pelanggan@gmail.com',
            'password' => Hash::make('password'),
        ]);

        // Berikan role customer ke akun customer
        $userCustomer->assignRole($roleCustomer);
    }
}
