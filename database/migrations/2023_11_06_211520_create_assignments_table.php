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
            $table->unsignedBigInteger('user_id_1')->nullable();
            $table->unsignedBigInteger('user_id_2')->nullable();
            $table->unsignedBigInteger('user_id_3')->nullable();
            $table->enum('type',["rango","codigos"])->default("rango");
            $table->integer('start')->nullable();
            $table->integer('end')->nullable();
            $table->text('codes')->nullable();
            $table->boolean('is_visible_in_web')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
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
        Schema::dropIfExists('assignments');
    }
};
