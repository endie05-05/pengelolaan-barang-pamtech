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
        Schema::create('field_report_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('field_report_id')->constrained('field_reports')->onDelete('cascade');
            $table->foreignId('project_material_id')->constrained('project_materials');
            $table->integer('qty_installed')->default(0);
            $table->integer('qty_damaged')->default(0);
            $table->integer('qty_leftover')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('field_report_items');
    }
};
