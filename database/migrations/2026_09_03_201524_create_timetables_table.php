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
        Schema::create('timetables', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('course_id');
            $table->unsignedBigInteger('lecturer_id');
            $table->unsignedBigInteger('location_id');
            $table->unsignedBigInteger('program_id');
            $table->unsignedBigInteger('level_id')->nullable(); // Optional: for specific level
            $table->date('date');
            $table->time('start_time');
            $table->time('end_time');
            $table->enum('day_of_week', [
                'monday',
                'tuesday',
                'wednesday',
                'thursday',
                'friday',
                'saturday',
                'sunday'
            ]);
            $table->integer('attendance_window_minutes')->default(15);
            $table->enum('status', ['scheduled', 'ongoing', 'completed', 'cancelled'])->default('scheduled');
            $table->text('cancel_reason')->nullable();
            $table->timestamps();

            // Indexes
            $table->index('course_id');
            $table->index('program_id');
            $table->index('lecturer_id');
            $table->index('location_id');
            $table->index('level_id');
            $table->index('date');
            $table->index(['lecturer_id', 'date']);
            $table->index(['location_id', 'date']);
            $table->index(['course_id', 'date']);
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('timetables');
    }
};
