<?php

namespace Database\Seeders;

use App\Models\Classification;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClassificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();
        $nameArr = ["Previous Maintenance Routine", "Previous Maintenance Non Routine", "Repair", "Replacement", "Vendor"];

        for($i = 0; $i < count($nameArr); $i++){
            Classification::create([
                'name' => $nameArr[$i],
                'deleted_at' => null,
            ]);
        }
    }
}
