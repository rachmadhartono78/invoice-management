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
        Schema::create('tickets', function (Blueprint $table) {
            $table->increments("id");
            $table->string("ticket_number");
            $table->string("reporter_name");
            $table->string("reporter_phone");
            $table->unsignedInteger("tenant_id");
            $table->foreign('tenant_id')->references('id')->on('tenants');
            $table->string("ticket_title");
            $table->text("ticket_body");
            $table->string("status");
            $table->timestamps();
            $table->date("deleted_at")->nullable();
        });

        Schema::create('ticket_attachments', function (Blueprint $table) {
            $table->increments("id");
            $table->unsignedInteger("ticket_id");
            $table->foreign('ticket_id')->references('id')->on('tickets');
            $table->mediumText("attachment");
            $table->timestamps();
            $table->date("deleted_at")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
        Schema::dropIfExists('ticket_attachments');
    }
};
