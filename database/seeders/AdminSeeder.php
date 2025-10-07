<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::create([
            'name' => 'Super Admin',
            'email' => 'admin@flatmanagement.com',
            'password' => Hash::make('password'),
        ]);

        $admin->assignRole('admin');

        $houseOner = User::create([
            'name' => 'House Oner',
            'email' => 'aziz@flatmanagement.com',
            'password' => Hash::make('password'),
        ]);

        $houseOner->assignRole('house_owner');
    }
}