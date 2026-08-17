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
        Schema::create('instruments', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('segment');
            $table->string('exchange');

            $table->string('isin')->nullable();
            $table->timestamp('expiry')->nullable();

            $table->string('country')->nullable();
            $table->string('latency')->nullable();
            $table->text('description')->nullable();
            $table->string('currency')->nullable();

            $table->boolean('weekly')->default(false);

            $table->string('instrument_key')->unique();
            $table->string('exchange_token');

            $table->string('trading_symbol');
            $table->string('short_name')->nullable();

            $table->decimal('tick_size', 20, 6)->nullable();
            $table->decimal('lot_size', 20, 6)->nullable();

            $table->string('instrument_type');
            $table->decimal('freeze_quantity', 20, 6)->nullable();

            $table->string('underlying_key')->nullable();
            $table->string('underlying_type')->nullable();
            $table->string('underlying_symbol')->nullable();

            $table->timestamp('last_trading_date')->nullable();

            $table->decimal('strike_price', 20, 6)->nullable();
            $table->string('price_quote_unit')->nullable();

            $table->decimal('qty_multiplier', 20, 6)->nullable();
            $table->decimal('minimum_lot', 20, 6)->nullable();

            $table->timestamp('start_time')->nullable();
            $table->timestamp('end_time')->nullable();

            $table->string('week_days')->nullable();

            $table->decimal('general_denominator', 20, 6)->nullable();
            $table->decimal('general_numerator', 20, 6)->nullable();
            $table->decimal('price_numerator', 20, 6)->nullable();
            $table->decimal('price_denominator', 20, 6)->nullable();

            $table->boolean('mtf_enabled')->nullable();
            $table->string('mtf_bracket')->nullable();

            $table->string('security_type')->nullable();

            $table->timestamps();

            // Useful indexes for instrument lookups
            $table->index('exchange');
            $table->index('segment');
            $table->index('exchange_token');
            $table->index('trading_symbol');
            $table->index('underlying_key');
            $table->index('underlying_symbol');
            $table->index('instrument_type');
            $table->index('expiry');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('instruments');
    }
};