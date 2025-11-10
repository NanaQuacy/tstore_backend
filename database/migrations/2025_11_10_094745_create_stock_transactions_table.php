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
        Schema::create('stock_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products');
            $table->foreignId('business_id')->constrained('businesses');
            $table->enum('transaction_type', ['purchase', 'sale', 'transfer_in', 'transfer_out', 'adjustment', 'return']);
            $table->enum('volume_type', ['unit', 'box','half_box']);
            $table->integer('volume_quantity');
            $table->integer('quantity');
            $table->integer('previous_quantity');
            $table->integer('new_quantity');
            $table->enum('reference_type', ['sale', 'transfer', 'adjustment', 'return'])->nullable();
            $table->string('reference_id')->nullable();
            $table->string('description')->nullable();
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
            $table->softDeletes();

            $table->index('product_id');
            $table->index('business_id');
            $table->index('reference_type');
            $table->index('reference_id');
            $table->index(['reference_type', 'reference_id']);
            $table->index('created_by');
        });
       
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_transactions');
    }
};
