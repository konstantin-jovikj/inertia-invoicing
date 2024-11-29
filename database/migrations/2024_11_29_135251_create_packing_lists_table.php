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
        Schema::create('packing_lists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('document_id')->constrained('documents');
            $table->foreignId('vehicle_id')->nullable()->constrained('vehicles');
            $table->foreignId('driver_id')->nullable()->constrained('drivers');
            $table->foreignId('curency_id')->nullable()->constrained('curencies');
            $table->foreignId('incoterm_id')->nullable()->constrained('incoterms');
            $table->foreignId('tax_id')->nullable()->constrained('taxes');
            $table->foreignId('term_id')->nullable()->constrained('terms');

            $table->boolean('is_translation')->default(false);
            $table->boolean('is_albanian')->default(false);
            $table->boolean('is_for_export')->default(false);
            $table->string('document_no')->nullable();
            $table->index('document_no');
            $table->dateTime('date')->nullable();
            $table->index(['date', 'document_type_id']);
            $table->string('drawing_no')->nullable();
            $table->string('delivery')->nullable();
            $table->decimal('advance_payment', 14, 2)->nullable();
            $table->decimal('discount', 5, 2)->nullable();
            $table->decimal('total', 14, 2)->nullable();
            $table->decimal('grand_total', 14, 2)->nullable();
            $table->decimal('advanced_payment_base', 14, 2)->nullable();
            $table->decimal('advanced_payment_tax', 14, 2)->nullable();
            $table->decimal('tax_amount', 14, 2)->nullable();
            $table->decimal('discount_amount', 14, 2)->default(0);
            $table->decimal('total_with_tax_and_discount', 14, 2)->nullable();
            $table->decimal('total_volume', 8, 2)->nullable();
            $table->decimal('total_weight', 7, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packing_lists');
    }
};
