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
        Schema::create('supply_chain_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supply_chain_id')->constrained()->onDelete('cascade');   
            $table->foreignId('inventory_id')->constrained()->onDelete('cascade');   
            $table->decimal('qty');
            $table->enum('uom', ['KG', 'MG', 'PCS']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supply_chain_items');
    }
};
