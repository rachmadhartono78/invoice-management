<?php

namespace Database\Seeders;

use App\Models\Bank;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BanksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 20; $i++) {
            Bank::create([
                'name' => "Bank {$faker->colorName}",
                'account_name' => $faker->name,
                'account_number' => "f0000a1293". $i,
                'branch_name' => "Branch {$faker->colorName}",
                'deleted_at' => null,
            ]);
        }
    }
}
