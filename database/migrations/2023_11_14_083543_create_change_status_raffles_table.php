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
        Schema::create('change_status_raffles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('raffle_id');
            $table->unsignedBigInteger('change_status_request_id');
            $table->enum('before_status', ['Liquidada', 'Stock', 'Fiada', 'Pagada', 'Reservada']);
            $table->enum('after_status', ['Liquidada', 'Stock', 'Fiada', 'Pagada', 'Reservada']);
            $table->string("custom_column_1")->nullable();
            $table->string("custom_column_2")->nullable();
            $table->string("custom_column_3")->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('change_status_raffles');
    }
};
