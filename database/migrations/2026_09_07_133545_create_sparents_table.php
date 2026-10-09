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
        Schema::create('sparents', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            // Student links (nullable)
            $table->string('student_id1', 30)->nullable();
            $table->string('student_id2', 30)->nullable();
            $table->string('student_id3', 30)->nullable();
            $table->string('student_id4', 30)->nullable();
             
            // Parent details
            $table->string('title', 20)->nullable(); // Mr, Mrs, Dr, etc.
            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->string('email')->unique();
            $table->string('phone', 20)->nullable();
            $table->string('alternate_phone', 20)->nullable();
            $table->string('occupation', 150)->nullable();
            $table->text('home_address')->nullable();
            $table->string('city', 100)->nullable();
            $table->string('state', 100)->nullable();
            $table->string('country', 100)->nullable();
            $table->string('postal_code', 20)->nullable();
            $table->string('emergency_contact_name', 150)->nullable();
            $table->string('emergency_contact_phone', 20)->nullable();
            $table->string('relationship_type', 50)->nullable(); // Father, Mother, Guardian
            $table->string('relationship_to_student', 50)->nullable(); // Father, Mother, Guardian, etc.
            $table->boolean('is_primary_contact')->default(false);
            $table->boolean('receives_notifications')->default(true);
            $table->boolean('is_active')->default(true);
           

            // Indexes
            $table->index('email');
            $table->index('phone');
            $table->index('is_active');
            $table->index('relationship_type');
            $table->index('student_id1');
            $table->index('student_id2');
            $table->index('student_id3');
            $table->index('student_id4');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sparents');
    }
};
