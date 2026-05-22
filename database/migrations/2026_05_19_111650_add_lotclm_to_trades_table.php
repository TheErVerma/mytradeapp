<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('trades', function (Blueprint $table) {
            // Add new columns
            $table->integer('trd_lot')->nullable();

            // Drop old columns
            $table->dropColumn([
                'trd_market_name',
                'trd_commissions',
                'trd_fees'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('trades', function (Blueprint $table) {
            // Restore dropped columns
            $table->string('trd_market_name');
            $table->decimal('trd_commissions', 15, 2)->default(0);
            $table->decimal('trd_fees', 15, 2)->default(0);

            // Remove added columns
            $table->dropColumn([
                'trd_lot',
            ]);
        });
    }
};
