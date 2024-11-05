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
        Schema::create('curencies', function (Blueprint $table) {
            $table->id();
            $table->string('code', 3)->unique(); // ISO currency code (e.g., EUR, USD)
            $table->string('symbol', 10); // Currency symbol
            $table->string('name'); // Full name of the currency
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('curencies');
    }
};
