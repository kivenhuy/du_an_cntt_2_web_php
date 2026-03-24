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
        if (!Schema::hasColumn('products', 'expired_date')) {
            Schema::table('products', function (Blueprint $table) {
                $table->dateTime('expired_date')->nullable()->after('discount_end_date');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('products', 'expired_date')) {
            Schema::table('products', function (Blueprint $table) {
                $table->dropColumn('expired_date');
            });
        }
    }
};
