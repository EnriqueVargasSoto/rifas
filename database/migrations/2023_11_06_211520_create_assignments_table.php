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
        Schema::create('assignments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('option1_id')->nullable();
            $table->foreign('option1_id')->references('id')->on('users');
            $table->unsignedBigInteger('option2_id')->nullable();
            $table->foreign('option2_id')->references('id')->on('users');
            $table->unsignedBigInteger('option3_id')->nullable();
            $table->foreign('option3_id')->references('id')->on('users');
            $table->integer('start');
            $table->integer('end');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assignments');
    }
};
