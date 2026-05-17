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
        Schema::create('trades', function (Blueprint $table) {
            $table->id();

            $table->string('trd_market_name');
            $table->string('trd_symbol');
            $table->string('trd_action');

            $table->date('trd_date');
            $table->time('trd_time');

            $table->integer('trd_shares');

            $table->decimal('trd_price', 15, 2);
            $table->decimal('trd_commissions', 15, 2)->default(0);
            $table->decimal('trd_fees', 15, 2)->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trades');
    }
};
