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
        Schema::create('levels', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('program_id');
            $table->string('name', 50); // e.g., "Year 1", "Level 100", "ND1"
            $table->string('code', 20); // e.g., "YR1", "L100", "ND1"
            $table->integer('level_order'); // 1, 2, 3, 4
            $table->text('description')->nullable();
            $table->timestamps();
            
            // Indexes
            $table->index('program_id');
            $table->index('level_order');
            
            // Unique constraints
            $table->unique(['program_id', 'name']);
            $table->unique(['program_id', 'code']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('levels');
    }
};