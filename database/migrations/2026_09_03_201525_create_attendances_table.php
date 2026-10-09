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
        Schema::create('attendance', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('timetable_id');
            $table->timestamp('clock_in_time');
            $table->timestamp('clock_out_time')->nullable();
            $table->decimal('clock_in_latitude', 10, 8);
            $table->decimal('clock_in_longitude', 11, 8);
            $table->decimal('clock_in_accuracy', 5, 2)->nullable();
            $table->decimal('distance_meters', 10, 2)->nullable();
            $table->enum('status', ['present', 'late', 'absent', 'excused'])->default('present');
            $table->enum('source', ['mobile', 'web', 'manual', 'qr_code'])->default('mobile');
            $table->text('remarks')->nullable();
            $table->timestamps();
            
            // Unique constraint to prevent duplicate clock-ins
            $table->unique(['student_id', 'timetable_id'], 'unique_attendance');
            
            // Indexes
            $table->index('student_id');
            $table->index('timetable_id');
            $table->index('clock_in_time');
            $table->index('status');
            $table->index(['student_id', 'clock_in_time']);
            $table->index(['timetable_id', 'status']);
            $table->index('source');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendance');
    }
};