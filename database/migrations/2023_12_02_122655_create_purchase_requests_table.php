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
        Schema::create('purchase_requests', function (Blueprint $table) {
            $table->increments("id");
            $table->string("purchase_request_number");
            $table->unsignedInteger("department_id");
            $table->foreign('department_id')->references('id')->on('departments');
            $table->unsignedInteger("proposed_purchase_price");
            $table->string("budget_status");
            $table->date("request_date");
            $table->string("status");
            $table->string("requester");
            $table->unsignedInteger("total_budget");
            $table->unsignedInteger("remaining_budget");
            $table->unsignedInteger("material_request_id");
            $table->foreign('material_request_id')->references('id')->on('material_requests');
            $table->text("additional_note")->nullable();
            $table->timestamps();
            $table->date("deleted_at")->nullable();
        });

        Schema::create('purchase_request_detail', function (Blueprint $table) {
            $table->unsignedInteger("purchase_request_id");
            $table->foreign('purchase_request_id')->references('id')->on('purchase_requests');
            $table->integer("number");
            $table->string("part_number");
            $table->date("last_buy_date");
            $table->integer("last_buy_quantity");
            $table->integer("last_buy_stock");
            $table->text("description");
            $table->integer("quantity");
            $table->timestamps();
            $table->date("deleted_at")->nullable();
        });

        Schema::create('purchase_request_signature', function (Blueprint $table) {
            $table->unsignedInteger("purchase_request_id");
            $table->foreign('purchase_request_id')->references('id')->on('purchase_requests');
            $table->string("type")->nullable();
            $table->string("name")->nullable();
            $table->mediumText("signature")->nullable();
            $table->date("date")->nullable();
            $table->timestamps();
            $table->date("deleted_at")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_requests');
        Schema::dropIfExists('purchase_request_detail');
        Schema::dropIfExists('purchase_request_signature');
    }
};
