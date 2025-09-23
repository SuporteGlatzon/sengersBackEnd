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
        Schema::table('users', function (Blueprint $table) {
            $table->string('avatar')->nullable();
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->text('complement')->nullable();

            $table->foreignId('state_id')->nullable();
            $table->foreign('state_id')->references('id')->on('states');

            $table->foreignId('city_id')->nullable();
            $table->foreign('city_id')->references('id')->on('cities');

            $table->text('description')->nullable();
            $table->text('full_description')->nullable();

            $table->string('link_site')->nullable();
            $table->string('link_instagram')->nullable();
            $table->string('link_twitter')->nullable();
            $table->string('link_linkedin')->nullable();

            $table->string('banner_profile')->nullable();
            $table->boolean('senge_associate')->default(false);

            $table->string('curriculum')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['state_id']);
            $table->dropColumn('state_id');

            $table->dropForeign(['city_id']);
            $table->dropColumn('city_id');

            $table->dropColumn('avatar');
            $table->dropColumn('phone');
            $table->dropColumn('address');
            $table->dropColumn('complement');

            $table->dropColumn('description');
            $table->dropColumn('full_description');

            $table->dropColumn('link_site');
            $table->dropColumn('link_instagram');
            $table->dropColumn('link_twitter');
            $table->dropColumn('link_linkedin');

            $table->dropColumn('banner_profile');
            $table->dropColumn('senge_associate');

            $table->dropColumn('curriculum');
        });
    }
};
