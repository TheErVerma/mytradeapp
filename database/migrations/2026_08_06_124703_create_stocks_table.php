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
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();

            $table->string('symbol', 20)->unique();
            $table->string('title');
            $table->enum('exchange', ['NSE', 'BSE']);
            $table->enum('instrument_type', ['EQ', 'ETF', 'FUT', 'CE', 'PE', 'INDEX'])->default('EQ');

            $table->string('series', 10)->nullable();
            $table->string('isin', 20)->nullable()->unique();

            $table->string('sector')->nullable();
            $table->string('industry')->nullable();

            $table->unsignedInteger('lot_size')->default(1);
            $table->decimal('tick_size', 8, 4)->default(0.05);
            $table->decimal('face_value', 10, 2)->nullable();

            $table->text('description')->nullable();
            $table->string('logo')->nullable();
            $table->string('website')->nullable();

            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stocks');
    }
};
