<?php

namespace Database\Seeders;

use App\Models\Invoice;
use App\Models\InvoiceDetail;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InvoicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Invoice::truncate();
        // InvoiceDetail::truncate();

        $status = ["Terbuat", "Disetujui KA", "Disetujui BM", "Terkirim", "Kurang Bayar", "Lunas"];
        $spelled = ["Seratus ribu rupiah", "Dua ratus ribu rupiah", "Tiga ratus ribu rupiah", "Empat ratus ribu rupiah", "Lima ratus ribu rupiah", "Enam ratus ribu rupiah"];

        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 12; $i++) {
            $count = $i + 1;
            $grandTotal = $count * 100000;
            $startDate = $faker->dateTimeBetween('-2 week', '-1 week');
            $dataIndex = $i % 6;

            Invoice::create([
                "paper_id" => "21a95784-7f12-4bf7-b262-dd6ae0b95f1a",
                "is_stamped" => false,
                "pdf_link" => "",
                "tenant_id" => $count,
                "grand_total" => $grandTotal,
                "invoice_date" => $startDate,
                "invoice_due_date" => $faker->dateTimeBetween('+1 week', '+2 week'),
                "notes" => $faker->text,
                "term_and_condition" => $faker->text,
                "status" => $status[$dataIndex],
                'deleted_at' => null,
            ]);

            for($j = 1; $j <= 5; $j++){
                $totalPrice = $grandTotal / 5;
                $tax = $totalPrice * 0.1;
                $price = $totalPrice - $tax;

                InvoiceDetail::create([
                    "invoice_id" => $count,
                    "item" => "Item {$j}",
                    "description" => $faker->text,
                    "quantity" => 1,
                    "price" => $price,
                    "tax_id" => "10",
                    "discount" => 0,
                    "total_price" => $totalPrice,
                    'deleted_at' => null,
                ]);
            }
        }
    }
}
