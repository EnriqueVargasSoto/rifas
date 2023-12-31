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
        Schema::create('raffles', function (Blueprint $table) {
            $table->id();
            $table->integer('number');
            $table->string('code');
            $table->string("url_image")->nullable();
            $table->enum('status', ["Liquidada",'Por aprobar', "Stock", "Fiada", "Pagada", "Reservada"])->default("Stock");
            $table->boolean('is_visible_in_web')->default(false);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_available')->default(true);
            $table->decimal('price', 10, 2)->default(20);
            $table->unsignedBigInteger('user_id_1')->nullable();
            $table->unsignedBigInteger('user_id_2')->nullable();
            $table->unsignedBigInteger('user_id_3')->nullable();
            $table->unsignedBigInteger('order_item_id')->nullable();
            $table->unsignedBigInteger('order_id')->nullable();
            $table->text('transaction_id')->nullable();
            $table->text('transaction_liquidation_id')->nullable();
            $table->text('liquidation_image_url')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->dateTime('liquidation_at')->nullable();
            $table->dateTime('payment_at')->nullable();
            $table->dateTime('reserved_at')->nullable();
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
        Schema::dropIfExists('raffles');
    }
};
