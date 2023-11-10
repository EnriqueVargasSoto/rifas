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
        Schema::create('assignment_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('assignment_id')->nullable();
            $table->foreign('assignment_id')->references('id')->on('assignments');
            $table->unsignedBigInteger('option1_id')->nullable();
            $table->foreign('option1_id')->references('id')->on('users');
            $table->unsignedBigInteger('option2_id')->nullable();
            $table->foreign('option2_id')->references('id')->on('users');
            $table->unsignedBigInteger('option3_id')->nullable();
            $table->foreign('option3_id')->references('id')->on('users');
            $table->unsignedBigInteger('raffle_id')->nullable();
            $table->foreign('raffle_id')->references('id')->on('raffles');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assignment_details');
    }
};
