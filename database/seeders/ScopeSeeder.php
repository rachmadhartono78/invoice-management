<?php

namespace Database\Seeders;

use App\Models\Scope;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ScopeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();
        $nameArr = ["Telekomunikasi", "Electric", "Plumbing", "Civil", "BAS", "MDP", "HVAC", "Lift", "Fire System", "GENSET", "Others"];

        for($i = 0; $i < count($nameArr); $i++){
            Scope::create([
                'name' => $nameArr[$i],
                'deleted_at' => null,
            ]);
        }
    }
}
