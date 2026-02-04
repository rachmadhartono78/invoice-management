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
        Schema::create('work_orders', function (Blueprint $table) {
            $table->increments("id");
            $table->string("work_order_number");
            $table->string("scope");
            $table->string("classification");
            $table->date("work_order_date");
            $table->date("action_plan_date");
            $table->string("status");
            $table->unsignedInteger("damage_report_id");
            $table->foreign('damage_report_id')->references('id')->on('damage_reports');
            $table->date("finish_plan");
            $table->text("job_description");
            $table->string("klasifikasi");
            $table->timestamps();
            $table->date("deleted_at")->nullable();
        });

        Schema::create('work_order_details', function (Blueprint $table) {
            $table->unsignedInteger("work_order_id");
            $table->foreign('work_order_id')->references('id')->on('work_orders');
            $table->string("location");
            $table->string("material_request");
            $table->string("type");
            $table->integer("quantity");
            $table->timestamps();
            $table->date("deleted_at")->nullable();
        });

        Schema::create('work_order_signature', function (Blueprint $table) {
            $table->unsignedInteger("work_order_id");
            $table->foreign('work_order_id')->references('id')->on('work_orders');
            $table->string("name")->nullable();
            $table->string("position")->nullable();
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
        Schema::dropIfExists('work_orders');
        Schema::dropIfExists('work_order_details');
        Schema::dropIfExists('work_order_signature');
    }
};
