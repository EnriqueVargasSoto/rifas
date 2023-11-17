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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id');
            $table->decimal('total', 10, 2)->default(0);
            $table->string('payment_method')->nullable();
            $table->string('transaction_id')->nullable();
            $table->string('image_payment_url')->nullable();
            $table->string('invoice_url')->nullable();
            $table->unsignedBigInteger('aproved_by')->nullable();
            $table->unsignedBigInteger('cancelled_by')->nullable();
            $table->dateTime('aproved_at')->nullable();
            $table->dateTime('cancelled_at')->nullable();
            $table->enum('status',['reservado','aprobado', 'cancelado'])->default('reservado');
            $table->text('rejection_reason')->nullable();
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
        Schema::dropIfExists('orders');
    }
};
