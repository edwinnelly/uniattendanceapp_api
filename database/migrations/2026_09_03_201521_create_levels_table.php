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
            $table->string('name', 50); // e.g., "Year 1", "Level 100", "ND1"
            $table->string('code', 20); // e.g., "YR1", "L100", "ND1"          
            $table->text('description')->nullable();
            $table->timestamps();
                   
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