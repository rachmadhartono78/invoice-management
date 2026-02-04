<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->increments("id");
            $table->string("paper_id")->nullable();
            $table->boolean("is_stamped")->default(false);
            $table->string("pdf_link")->default("");
            $table->string("invoice_number");
            $table->unsignedInteger("tenant_id");
            $table->foreign('tenant_id')->references('id')->on('tenants');
            $table->unsignedInteger("grand_total");
            $table->mediumText("notes")->nullable();
            $table->mediumText("term_and_condition")->nullable();
            $table->date("invoice_date");
            $table->date("invoice_due_date");
            $table->string("status", 255);
            $table->timestamps();
            $table->date("deleted_at")->nullable();
        });

        Schema::create('invoice_details', function (Blueprint $table) {
            $table->unsignedInteger("invoice_id");
            $table->foreign('invoice_id')->references('id')->on('invoices');
            $table->string('item');
            $table->text('description');
            $table->integer("quantity");
            $table->integer("price");
            $table->string("tax_id")->nullable();
            $table->float("discount");
            $table->integer("total_price");
            $table->timestamps();
            $table->date("deleted_at")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
        Schema::dropIfExists('invoice_details');
    }
};
