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
        Schema::create('option_chain', function (Blueprint $table) {
            $table->id();
            $table->string('symbol');
            $table->date('expiry_date');
            $table->string('option_type');
            $table->decimal('strike_price', 10, 2);
            $table->decimal('last_price', 10, 2);
            $table->decimal('change', 10, 2);
            $table->decimal('percent_change', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('option_chain');
    }
};
