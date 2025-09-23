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
            $table->softDeletes();
        });

        Schema::table('opportunity_types', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('occupation_areas', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('opportunities', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('home_associates', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('home_banners', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('home_book_rooms', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('educations', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('settings', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

        Schema::table('users', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('opportunity_types', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('occupation_areas', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('opportunities', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('home_associates', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('home_banners', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('home_book_rooms', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('educations', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('settings', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
