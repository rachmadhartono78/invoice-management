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
        Schema::create('damage_reports', function (Blueprint $table) {
            $table->increments("id");
            $table->string("damage_report_number");
            $table->string("scope");
            $table->string("classification");
            $table->date("damage_report_date");
            $table->date("action_plan_date");
            $table->string("status");
            $table->unsignedInteger("ticket_id");
            $table->foreign('ticket_id')->references('id')->on('tickets');
            $table->timestamps();
            $table->date("deleted_at")->nullable();
        });

        Schema::create('damage_report_detail', function (Blueprint $table) {
            $table->unsignedInteger("damage_report_id");
            $table->foreign('damage_report_id')->references('id')->on('damage_reports');
            $table->string("category");
            $table->string("location");
            $table->integer("total");
            $table->timestamps();
            $table->date("deleted_at")->nullable();
        });

        Schema::create('damage_report_signature', function (Blueprint $table) {
            $table->unsignedInteger("damage_report_id");
            $table->foreign('damage_report_id')->references('id')->on('damage_reports');
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
        Schema::dropIfExists('damage_reports');
        Schema::dropIfExists('damage_report_detail');
        Schema::dropIfExists('damage_report_signature');
    }
};
