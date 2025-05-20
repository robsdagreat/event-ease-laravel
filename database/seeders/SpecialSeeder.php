<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Special;
use Carbon\Carbon;

class SpecialSeeder extends Seeder
{
    public function run()
    {
        $specials = [
            [
                'title' => 'Summer Happy Hour',
                'description' => '50% off on all drinks during happy hour',
                'establishment_name' => 'Sunset Bar & Grill',
                'establishment_type' => 'bar',
                'location' => 'Miami Beach',
                'start_date' => Carbon::now(),
                'end_date' => Carbon::now()->addMonths(3),
                'type' => 'weekend',
                'discount_percentage' => 50,
                'image_url' => 'https://example.com/happy-hour.jpg',
                'is_active' => true,
                'terms' => [
                    'Valid only during happy hour (4 PM - 7 PM)',
                    'Not valid on holidays',
                    'Cannot be combined with other offers'
                ],
                'contact_email' => 'info@sunsetbar.com',
                'contact_phone' => '123-456-7890',
                'website' => 'https://sunsetbar.com'
            ],
            [
                'title' => 'Weekend Brunch Special',
                'description' => '30% off on all brunch items',
                'establishment_name' => 'Ocean View Restaurant',
                'establishment_type' => 'restaurant',
                'location' => 'Miami Downtown',
                'start_date' => Carbon::now(),
                'end_date' => Carbon::now()->addMonths(2),
                'type' => 'weekend',
                'discount_percentage' => 30,
                'image_url' => 'https://example.com/brunch.jpg',
                'is_active' => true,
                'terms' => [
                    'Valid only on weekends',
                    'Reservation required',
                    'Limited to 4 people per table'
                ],
                'contact_email' => 'reservations@oceanview.com',
                'contact_phone' => '234-567-8901',
                'website' => 'https://oceanview.com'
            ],
            [
                'title' => 'Valentine\'s Day Package',
                'description' => 'Special romantic dinner package for couples',
                'establishment_name' => 'Luxury Hotel & Spa',
                'establishment_type' => 'hotel',
                'location' => 'Miami Beach',
                'start_date' => Carbon::now()->addDays(10),
                'end_date' => Carbon::now()->addDays(15),
                'type' => 'valentine',
                'discount_percentage' => 25,
                'image_url' => 'https://example.com/valentine.jpg',
                'is_active' => true,
                'terms' => [
                    'Includes 3-course dinner',
                    'Complimentary champagne',
                    'Reservation required'
                ],
                'contact_email' => 'romance@luxuryhotel.com',
                'contact_phone' => '345-678-9012',
                'website' => 'https://luxuryhotel.com'
            ]
        ];

        foreach ($specials as $special) {
            Special::create($special);
        }
    }
} 