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
            $table->string('barcode')->unique()->nullable();
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('selling_price', 8, 2);
            $table->decimal('cost_price', 8, 2)->nullable();
 
            // Changed from integer to decimal: 'unit' allows 'kg'/'g',
            // and weight-based stock can be fractional (e.g. 2.5 kg).
            // If you only ever sell/stock whole units, integer is fine —
            // but as written, this column needs to support fractions.
            $table->decimal('quantity', 10, 2)->default(0);
 
            $table->string('unit')->default('pcs'); // pcs, kg, g, sachets
            $table->string('image')->nullable();
 
            $table->timestamps();
 
            // Lets you retire a discontinued product without breaking
            // foreign keys on past order/transaction line items.
            $table->softDeletes();
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
