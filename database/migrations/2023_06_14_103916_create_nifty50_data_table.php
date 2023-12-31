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
        Schema::create('nifty50_data', function (Blueprint $table) {

                $table->id();
                $table->float('open');
                $table->float('close');
                $table->float('low');
                $table->float('high');
                $table->timestamp('timestamp');
                $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nifty50_data');
    }
};
