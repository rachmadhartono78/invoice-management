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
        Schema::create('banks', function (Blueprint $table) {
            $table->increments("id");
            $table->string("name");
            $table->string("account_name");
            $table->string("account_number");
            $table->string("branch_name");
            $table->timestamps();
            $table->date("deleted_at")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banks');
    }
};
