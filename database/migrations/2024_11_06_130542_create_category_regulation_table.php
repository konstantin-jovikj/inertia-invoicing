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
        Schema::create('category_regulation', function (Blueprint $table) {
            $table->id();
            $table->foreignId(column: 'category_id')->nullable()->constrained('categories');
            $table->foreignId(column: 'regulation_id')->nullable()->constrained('regulations');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category_regulation');
    }
};
