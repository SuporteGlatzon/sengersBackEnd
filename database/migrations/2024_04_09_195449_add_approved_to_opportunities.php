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
            $table->boolean('approved')->default(false)->index();
            $table->dateTime('expire_at')->nullable()->index();
            $table->dateTime('expire_notification_at')->nullable()->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('opportunities', function (Blueprint $table) {
            $table->dropColumn('approved');
            $table->dropColumn('expire_at');
            $table->dropColumn('expire_notification_at');
        });
    }
};
