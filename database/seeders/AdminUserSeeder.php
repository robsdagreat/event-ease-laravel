<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@eventease.com',
            'password' => Hash::make('admin1234'), // Use a secure password in production
            'firebase_uid' => 'admin_user_firebase_uid',
            'is_admin' => true,
        ]);
    }
}