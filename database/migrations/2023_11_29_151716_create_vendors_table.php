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
        Schema::create('vendors', function (Blueprint $table) {
            $table->increments("id");
            $table->string("name");
            $table->string("email");
            $table->string("phone", 15);
            $table->string("address");
            $table->string("floor");
            $table->string("status");
            $table->timestamps();
            $table->date("deleted_at")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendors');
    }
};
