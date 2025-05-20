<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FirebaseUserSeeder extends Seeder
{
    public function run()
    {
        DB::table('firebase_users')->updateOrInsert([
            'uid' => 'user123',
        ], [
            'email' => 'test@example.com',
            'display_name' => 'Test User',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
} 