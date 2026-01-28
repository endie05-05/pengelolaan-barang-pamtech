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
        Schema::create('material_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('template_id')->nullable()->constrained('project_templates')->onDelete('set null');
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            
            // Project Info
            $table->string('project_name');
            $table->string('technician_name');
            $table->string('location')->nullable();
            $table->date('departure_date')->nullable();
            $table->text('notes')->nullable();
            
            // Status: pending -> checked_out -> returned -> closed
            $table->enum('status', ['pending', 'checked_out', 'returned', 'closed'])->default('pending');
            
            // Checkout info
            $table->foreignId('checkout_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('checkout_at')->nullable();
            
            // Checkin info
            $table->foreignId('checkin_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('checkin_at')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('material_requests');
    }
};
