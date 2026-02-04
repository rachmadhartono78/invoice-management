<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();
        $nameArr = ["CS", "Teknik", "BM", "KA Unit Umum", "KA Unit Account"];

        for($i = 0; $i < count($nameArr); $i++){
            Department::create([
                'name' => $nameArr[$i],
                'deleted_at' => null,
            ]);
        }
    }
}
