<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);


        Product::factory(1)->create([
            'freight_data' => [
                'origin' => [
                    'city' => 'HARRISON',
                    'postalCode' => '726016353',
                    'countryCode' => 'US',
                    'streetLines' => ['1202 CHALET LN'],
                    'stateOrProvinceCode' => 'AR',
                ],
                'lineItems' => [[
                    'id' => 'books',
                    'pieces' => 1,
                    'weight' => ['units' => 'LB', 'value' => '40'],
                    'freightClass' => 'CLASS_050',
                    'handlingUnits' => 1,
                    'subPackagingType' => 'BUNDLE',
                ]],
                'destination' => [
                    'city' => 'MIAMI',
                    'postalCode' => '331662829',
                    'countryCode' => 'US',
                    'streetLines' => ['Sed repudiandae dign'],
                    'stateOrProvinceCode' => 'FL',
                ],
            ],
        ]);
    }
}
