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
            $table->bigIncrements('id');
            $table->string('trd_symbol');
            $table->string('trd_action');
            $table->date('trd_date');
            $table->integer('trd_shares');
            $table->decimal('trd_price', 15);
            $table->timestamps();
            $table->string('user_id')->nullable();
            $table->integer('trd_lot')->nullable();
            $table->string('trd_type');
            $table->string('trd_screenshots')->nullable();
            $table->string('notes')->nullable();
            $table->decimal('trd_exit_price')->nullable();
            $table->decimal('trd_charges_amount')->nullable();
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
