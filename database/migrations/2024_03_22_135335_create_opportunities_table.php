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
        Schema::create('opportunities', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id');
            $table->foreign('user_id')->references('id')->on('users');

            $table->string('company')->nullable();

            $table->foreignId('state_id')->nullable();
            $table->foreign('state_id')->references('id')->on('states');

            $table->foreignId('city_id')->nullable();
            $table->foreign('city_id')->references('id')->on('cities');

            $table->string('title');
            $table->text('description')->nullable();
            $table->text('full_description')->nullable();

            $table->boolean('status')->default(false);

            $table->date('date')->nullable();
            $table->string('salary')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('opportunities');
    }
};
