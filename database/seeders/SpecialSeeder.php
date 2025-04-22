<?php

namespace Database\Seeders;

use App\Models\Special;
use Illuminate\Database\Seeder;

class SpecialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $specials = [
            [
                'name' => 'Beach Resort Weekend',
                'discount' => '30% Off',
                'location' => 'Coastal Bay',
                'image_url' => 'https://picsum.photos/id/1003/400/300',
                'original_price' => 300,
                'discounted_price' => 210,
                'valid_until' => now()->addMonths(3)->toDateString(),
                'is_active' => true,
                'description' => 'Enjoy a luxurious weekend at our beach resort with a special discount.',
            ],
            [
                'name' => 'Spa Retreat Package',
                'discount' => '25% Off',
                'location' => 'Mountain View',
                'image_url' => 'https://picsum.photos/id/1004/400/300',
                'original_price' => 250,
                'discounted_price' => 187.5,
                'valid_until' => now()->addMonths(2)->toDateString(),
                'is_active' => true,
                'description' => 'Relax and rejuvenate with our spa retreat package.',
            ],
            [
                'name' => 'City Tour Bundle',
                'discount' => '40% Off',
                'location' => 'Downtown',
                'image_url' => 'https://picsum.photos/id/1005/400/300',
                'original_price' => 120,
                'discounted_price' => 72,
                'valid_until' => now()->addMonths(1)->toDateString(),
                'is_active' => true,
                'description' => 'Explore the city with our guided tour bundle at a special price.',
            ],
            [
                'name' => 'Valentine\'s Day Dinner',
                'discount' => '20% Off',
                'location' => 'Luxury Hotel',
                'image_url' => 'https://picsum.photos/id/1006/400/300',
                'original_price' => 180,
                'discounted_price' => 144,
                'valid_until' => now()->addMonths(4)->toDateString(),
                'is_active' => true,
                'description' => 'Celebrate Valentine\'s Day with a romantic dinner at our luxury hotel.',
            ],
            [
                'name' => 'Couple\'s Retreat',
                'discount' => '35% Off',
                'location' => 'Seaside Resort',
                'image_url' => 'https://picsum.photos/id/1007/400/300',
                'original_price' => 350,
                'discounted_price' => 227.5,
                'valid_until' => now()->addMonths(3)->toDateString(),
                'is_active' => true,
                'description' => 'Spend quality time with your loved one at our seaside resort.',
            ],
        ];

        foreach ($specials as $special) {
            Special::create($special);
        }
    }
}