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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId(column: 'temperature_id')->nullable()->constrained('temperatures');
            $table->foreignId(column: 'voltage_id')->nullable()->constrained('voltages');
            $table->foreignId(column: 'manufacturer_id')->nullable()->constrained('manufacturers');
            $table->foreignId(column: 'category_id')->nullable()->constrained('categories');
            $table->foreignId(column: 'document_id')->nullable()->constrained('documents');
            $table->foreignId(column: 'model_id')->nullable()->constrained('product_models');
            $table->foreignId(column: 'refrigerant_id')->nullable()->constrained('refrigerants');


            $table->string('product_code')->nullable();
            $table->string('serial_no')->nullable();
            $table->string('description')->nullable();
            $table->decimal('length',7,2)->nullable();
            $table->decimal('width',7,2)->nullable();
            $table->decimal('height',7,2)->nullable();
            $table->decimal('weight',7,2)->nullable();
            $table->decimal('qty',5,2)->nullable();
            $table->decimal('single_price',11,2)->nullable();
            $table->decimal('total_price',11,2)->nullable();
            $table->decimal('product_total_volume',6,2)->nullable();
            $table->decimal('product_total_weight',7,2)->nullable();
            $table->decimal('hfc_qty',5,2)->nullable();
            $table->decimal('co2',8,2)->nullable();
            $table->decimal('power',8,2)->nullable();
            $table->decimal('current',5,2)->nullable();


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
