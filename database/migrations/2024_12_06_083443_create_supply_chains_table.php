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
        Schema::create('supply_chains', function (Blueprint $table) {
            $table->id();
            $table->string('in_charge');
            $table->string('receipt')->nullable();
            $table->decimal('amount');
            $table->enum('status', ['pending', 'approved', 'rejected']); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supply_chains');
    }
};
