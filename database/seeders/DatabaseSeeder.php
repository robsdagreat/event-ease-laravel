<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            SpecialSeeder::class,
            FirebaseUserSeeder::class,
        ]);

        \App\Models\User::firstOrCreate([
            'email' => 'system@eventease.com',
        ], [
            'name' => 'EventEase System',
            'password' => bcrypt('system_password'), // Change this to a secure password
            'is_system' => true,
        ]);
    }
}
