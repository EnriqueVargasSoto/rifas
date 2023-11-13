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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('payment_method')->nullable();
            $table->string('transaction_id')->nullable();
            $table->unsignedBigInteger('client_id')->nullable();
            $table->unsignedBigInteger('order_id')->nullable();
            $table->unsignedBigInteger('raffle_id');
            $table->date('payment_at')->nullable();
            $table->decimal('total', 10, 2)->default(0);
            $table->string('image_payment_url')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
