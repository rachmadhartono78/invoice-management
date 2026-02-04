<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(DepartmentSeeder::class);
        $this->call(LevelSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(ClassificationSeeder::class);
        $this->call(ScopeSeeder::class);
        $this->call(TenantsTableSeeder::class);
        $this->call(BanksTableSeeder::class);
        $this->call(TaxSeeder::class);
        $this->call(InvoicesTableSeeder::class);
        $this->call(ReceiptSeeder::class);
        $this->call(TicketSeeder::class);
        $this->call(DamageReportSeeder::class);
        $this->call(WorkOrderSeeder::class);
        $this->call(VendorSeeder::class);
        $this->call(MaterialRequestSeeder::class);
        $this->call(PurchaseRequestSeeder::class);
        $this->call(PurchaseOrderSeeder::class);
    }
}
