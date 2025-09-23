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
        Schema::table('opportunities', function (Blueprint $table) {
            $table->dropIndex(['approved']);
            $table->dropColumn('approved');
            $table->string('situation')->default('pending')->index();
            $table->string('situation_description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('opportunities', function (Blueprint $table) {
            $table->dropColumn('situation');
            $table->dropColumn('situation_description');
            $table->boolean('approved')->default(false)->index();
        });
    }
};
