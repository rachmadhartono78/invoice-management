<?php

namespace Database\Seeders;

use App\Models\Tax;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaxSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();

        for ($i = 1; $i <= 20; $i++) {
            Tax::create([
                "name" => "Pajak {$i}",
                "rate" => $i,
                "description" => $faker->text,
                "deleted_at" => null,
            ]);
        }
    }
}
