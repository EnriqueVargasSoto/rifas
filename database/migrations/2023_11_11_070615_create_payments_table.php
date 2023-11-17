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
            $table->unsignedBigInteger('raffle_id')->nullable();
            $table->decimal('total', 10, 2)->default(0);
            $table->string('image_payment_url')->nullable();
            $table->enum('model', ['order', 'raffle']);
            $table->dateTime('payment_at')->nullable();
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
        Schema::dropIfExists('payments');
    }
};
