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
        Schema::create('receipts', function (Blueprint $table) {
            $table->increments("id");
            $table->string("receipt_number");
            $table->unsignedInteger("grand_total");
            $table->date("receipt_date");
            $table->date("receipt_send_date")->nullable();
            $table->unsignedInteger("tenant_id");
            $table->foreign('tenant_id')->references('id')->on('tenants');
            $table->unsignedInteger("invoice_id");
            $table->foreign('invoice_id')->references('id')->on('invoices');
            $table->string("status");
            $table->string("check_number")->nullable();
            $table->unsignedInteger("bank_id")->nullable();
            $table->foreign('bank_id')->references('id')->on('banks');
            $table->unsignedInteger("paid");
            $table->unsignedInteger("remaining");
            $table->string("grand_total_spelled");
            $table->text("note")->nullable();
            $table->date("signature_date")->nullable();
            $table->mediumText("signature_image")->nullable();
            $table->string("signature_name")->nullable();
            $table->timestamps();
            $table->date("deleted_at")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('receipts');
    }
};
