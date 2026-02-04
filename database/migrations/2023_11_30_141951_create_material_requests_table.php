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
        Schema::create('material_requests', function (Blueprint $table) {
            $table->increments("id");
            $table->string("material_request_number");
            $table->string("requester");
            $table->string("department");
            $table->date("request_date");
            $table->string("status");
            $table->integer("stock")->nullable();
            $table->string("purchase")->nullable();
            $table->text("note");
            $table->timestamps();
            $table->date("deleted_at")->nullable();
        });

        Schema::create('material_request_details', function (Blueprint $table) {
            $table->unsignedInteger("material_request_id");
            $table->foreign('material_request_id')->references('id')->on('material_requests');
            $table->integer("number");
            $table->string("part_number");
            $table->text("description");
            $table->integer("quantity");
            $table->integer("stock");
            $table->integer("stock_out");
            $table->integer("end_stock");
            $table->integer("min_stock");
            $table->timestamps();
            $table->date("deleted_at")->nullable();
        });

        Schema::create('material_request_signature', function (Blueprint $table) {
            $table->unsignedInteger("material_request_id");
            $table->foreign('material_request_id')->references('id')->on('material_requests');
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
        Schema::dropIfExists('material_requests');
        Schema::dropIfExists('material_request_details');
        Schema::dropIfExists('material_request_signature');
    }
};
