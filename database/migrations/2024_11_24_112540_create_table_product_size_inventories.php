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
        Schema::create('product_size_inventories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_size_id')->constrained('product_sizes')->onDelete('cascade'); 
            $table->foreignId('inventory_id')->constrained('inventories')->onDelete('cascade'); 
            $table->decimal('quantity', 8, 2); 
            $table->enum('uom', ['KG', 'MG', 'PCS','ML','LITERS']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_product_size_inventories');
    }
};
