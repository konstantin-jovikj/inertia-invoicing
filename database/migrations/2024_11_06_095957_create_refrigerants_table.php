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
        Schema::create('refrigerants', function (Blueprint $table) {
            $table->id();
            $table->string('short_name')->nullable();
            $table->string('synonym')->nullable();
            $table->string('formula')->nullable();
            $table->integer('gwp')->nullable();
            $table->string('boiling_point')->nullable();
            $table->string('freezing_point')->nullable();
            $table->string('flammability')->nullable();
            $table->string('oxidizing')->nullable();
            $table->string('vapour_pressure')->nullable();
            $table->string('relative_density')->nullable();
            $table->text('evaporating_temp')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('refrigerants');
    }
};
