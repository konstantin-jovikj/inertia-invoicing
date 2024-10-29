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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->foreignId(column: 'user_id')->constrained('users');
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade')->nullable();
            $table->string('name');
            $table->string('tax_number')->nullable();
            $table->string('vat_number')->nullable();
            $table->string('reg_number')->nullable();
            $table->string('logo')->nullable();
            $table->string('cert')->nullable();
            $table->string('web')->nullable();
            $table->boolean('is_customer')->default(true);


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
