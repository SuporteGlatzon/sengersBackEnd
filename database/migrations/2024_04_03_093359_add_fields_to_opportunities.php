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
            $table->foreignId('opportunity_type_id')->nullable();
            $table->foreign('opportunity_type_id')->references('id')->on('opportunity_types');

            $table->foreignId('occupation_area_id')->nullable();
            $table->foreign('occupation_area_id')->references('id')->on('occupation_areas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('opportunities', function (Blueprint $table) {
            $table->dropForeign(['opportunity_type_id']);
            $table->dropColumn('opportunity_type_id');

            $table->dropForeign(['occupation_area_id']);
            $table->dropColumn('occupation_area_id');
        });
    }
};
