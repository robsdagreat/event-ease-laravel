<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            EventTypeSeeder::class,
            VenueSeeder::class,
            SpecialSeeder::class,
            AdminUserSeeder::class,
        ]);
    }
}