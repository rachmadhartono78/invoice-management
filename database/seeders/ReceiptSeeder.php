<?php

namespace Database\Seeders;

use App\Models\Receipt;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReceiptSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $status = ["Terbuat", "Disetujui KA", "Disetujui BM", "Terkirim", "Terkirim"];
        $spelled = ["Seratus ribu rupiah", "Dua ratus ribu rupiah", "Tiga ratus ribu rupiah", "Empat ratus ribu rupiah", "Lima ratus ribu rupiah"];

        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 12; $i++) {
            $count = $i + 1;
            $grandTotal = $count * 100000;
            $startDate = $faker->dateTimeBetween('-2 week', '-1 week');
            $dataIndex = $i % 5;

            Receipt::create([
                "grand_total" => $grandTotal,
                "receipt_date" => $startDate,
                "receipt_send_date" => $faker->dateTimeBetween('+1 week', '+2 week'),
                "tenant_id" => $count,
                "invoice_id" => $count,
                "status" => $status[$dataIndex],
                "check_number" => "CHE/GIR/O/{$count}",
                "bank_id" => $count,
                "paid" => $grandTotal,
                "remaining" => 0,
                "grand_total_spelled" => $spelled[$dataIndex],
                "note" => $faker->text,
                "signature_date" => $startDate,
                "signature_image" => "",
                "signature_name" => $faker->name,
                'deleted_at' => null,
            ]);
        }
    }
}
