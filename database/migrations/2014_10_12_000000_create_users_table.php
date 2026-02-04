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
        Schema::create('users', function (Blueprint $table) {
            $table->increments("id");
            $table->string('username');
            $table->string('password');
            $table->string('name');
            $table->string('email')->unique();
            $table->unsignedInteger('department_id');
            $table->foreign('department_id')->references('id')->on('departments');
            $table->unsignedInteger('level_id');
            $table->foreign('level_id')->references('id')->on('levels');
            $table->string('status');
            $table->mediumText("image")->nullable();
            $table->timestamps();
            $table->date("deleted_at")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
