<?php

namespace Database\Seeders;

use App\Models\Vendor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VendorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 20; $i++) {
            Vendor::create([
                'name' => "Vendor {$faker->colorName}",
                'email' => $faker->email,
                'phone' => "080000123{$i}",
                'address' => $faker->address,
                'floor' => "Lantai {$i}",
                'status' => "Active",
                'deleted_at' => null,
            ]);
        }
    }
}
