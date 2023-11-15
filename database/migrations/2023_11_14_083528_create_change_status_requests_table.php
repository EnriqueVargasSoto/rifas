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
        Schema::create('change_status_requests', function (Blueprint $table) {
            $table->id();
            $table->enum('status_request', ['Liquidada', 'Stock', 'Fiada', 'Pagada', 'Reservada']);
            $table->enum('status', ['Pendiente', 'Aprobado', 'Rechazado'])->default('Pendiente');
            $table->unsignedBigInteger('user_id_gestion')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->dateTime('approved_at')->nullable();
            $table->dateTime('rejected_at')->nullable();
            $table->text('transaction_id')->nullable();
            $table->text('image_url')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('change_status_requests');
    }
};
