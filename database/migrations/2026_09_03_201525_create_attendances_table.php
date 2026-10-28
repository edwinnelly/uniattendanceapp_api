<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attendance', function (Blueprint $table) {
            $table->id();

            $table->foreignId('student_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('timetable_id')->constrained()->cascadeOnDelete();

            // Column order here = column order in table. No ->after() in Schema::create().
            $table->date('session_date');

            $table->timestamp('clock_in_time');
            $table->timestamp('clock_out_time')->nullable();

            // Clock-in GPS — nullable because manual/QR sources have no GPS
            $table->decimal('clock_in_latitude', 10, 8)->nullable();
            $table->decimal('clock_in_longitude', 11, 8)->nullable();
            $table->decimal('clock_in_accuracy', 8, 2)->nullable();
            $table->decimal('distance_meters', 10, 2)->nullable();

            $table->enum('status', ['present', 'late', 'absent', 'excused']);
            $table->enum('source', ['mobile', 'web', 'manual', 'qr_code'])->default('mobile');
            $table->text('remarks')->nullable();

            // Who recorded this — FK to users, not free text
            $table->foreignId('recorded_by')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();
            $table->softDeletes();

            // One attendance record per student per timetable slot per date
            $table->unique(
                ['student_id', 'timetable_id', 'session_date'],
                'unique_attendance_per_session'
            );

            // Report/query indexes (FK indexes auto-created by foreignId())
            $table->index('clock_in_time');
            $table->index(['student_id', 'clock_in_time']);
            $table->index(['timetable_id', 'status']);
            $table->index('source');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendance');
    }
};