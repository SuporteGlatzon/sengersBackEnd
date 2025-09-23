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
        Schema::create('home_associates', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('orange_text')->nullable();
            $table->text('subtitle')->nullable();
            $table->string('title_right')->nullable();
            $table->string('button_link')->nullable();
            $table->string('button_text')->nullable();
            $table->text('advantages')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home_associates');
    }
};
