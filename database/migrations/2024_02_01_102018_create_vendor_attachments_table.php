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
        Schema::create('vendor_attachments', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger("purchase_order_id");
            $table->string("uraian");
            $table->mediumText("attachment");
            $table->foreign('purchase_order_id')->references('id')->on('purchase_orders');
            $table->timestamps();
            $table->date("deleted_at")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendor_attachments');
    }
};
