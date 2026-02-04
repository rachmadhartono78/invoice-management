<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();
        $image = "data:image/png;base64,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";

        User::create([
            'username' => "username0",
            'password' => Hash::make("123456"),
            'name' => $faker->name,
            'email'=> "test.invoice@pppgsi.com",
            'department_id' => 1,
            'level_id' => 1,
            'status' => "Active",
            "image" => $image,
        ]);

        for($i = 0; $i < 20; $i++){
            $count = $i + 1;
            $departmentIndex = $i % 5 + 1;
            $levelIndex = $i % 14 + 1;

            User::create([
                'username' => "username{$count}",
                'password' => Hash::make("123456"),
                'name' => $faker->name,
                'email'=> $faker->email,
                'department_id' => $departmentIndex,
                'level_id' => $levelIndex,
                'status' => "Active",
                "image" => $image,
            ]);
        }
    }
}
