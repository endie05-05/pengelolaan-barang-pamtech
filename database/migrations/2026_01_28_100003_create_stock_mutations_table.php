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
        Schema::create('stock_mutations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->constrained('items')->onDelete('cascade');
            
            // Type: in (masuk), out (keluar), adjust (penyesuaian), damaged, lost
            $table->enum('type', ['in', 'out', 'adjust', 'damaged', 'lost']);
            $table->integer('qty');
            $table->integer('stock_before');
            $table->integer('stock_after');
            
            // Reference to source (polymorphic-style)
            $table->string('reference_type')->nullable()->comment('Model class: MaterialRequest, etc');
            $table->unsignedBigInteger('reference_id')->nullable();
            
            $table->text('reason')->nullable();
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
            
            $table->index(['reference_type', 'reference_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_mutations');
    }
};
