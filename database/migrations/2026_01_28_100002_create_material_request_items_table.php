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
        Schema::create('material_request_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('material_request_id')->constrained('material_requests')->onDelete('cascade');
            $table->foreignId('item_id')->constrained('items')->onDelete('cascade');
            
            // Quantities
            $table->integer('qty_requested')->default(0)->comment('Jumlah yang diminta');
            $table->integer('qty_out')->default(0)->comment('Jumlah yang dikeluarkan (checkout)');
            $table->integer('qty_used')->default(0)->comment('Jumlah yang terpakai');
            $table->integer('qty_returned')->default(0)->comment('Jumlah yang dikembalikan');
            $table->integer('qty_damaged')->default(0)->comment('Jumlah yang rusak');
            $table->integer('qty_lost')->default(0)->comment('Jumlah yang hilang');
            
            // Condition tracking
            $table->enum('condition_out', ['good', 'fair'])->nullable()->comment('Kondisi saat keluar');
            $table->enum('condition_in', ['good', 'damaged', 'lost'])->nullable()->comment('Kondisi saat kembali');
            
            // Evidence
            $table->text('notes')->nullable();
            $table->string('photo_path')->nullable()->comment('Foto bukti jika ada selisih/kerusakan');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('material_request_items');
    }
};
