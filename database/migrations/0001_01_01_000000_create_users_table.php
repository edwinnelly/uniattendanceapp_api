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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');

            // Custom fields for attendance system
            $table->enum('user_type', ['student', 'lecturer', 'admin', 'parent'])->default('student');
            $table->string('phone', 20)->nullable();
            $table->string('profile_photo')->nullable();

            // Parent fields
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->string('relationship_to_student', 50)->nullable();

            // Student fields
            $table->string('student_number', 50)->unique()->nullable();
            $table->unsignedBigInteger('program_id')->nullable();
            $table->unsignedBigInteger('level_id')->nullable();
            $table->year('enrollment_year')->nullable();

            // Lecturer/Employee fields
            $table->string('employee_number', 50)->unique()->nullable();
            $table->unsignedBigInteger('department_id')->nullable();

            // Common fields
            $table->boolean('is_active')->default(true);

            $table->rememberToken();
            $table->timestamps();

            // Indexes
            $table->index('user_type');
            $table->index('program_id');
            $table->index('level_id');
            $table->index('department_id');
            $table->index('student_number');
            $table->index('employee_number');
            $table->index('is_active');
            $table->index('parent_id');
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('users');
    }
};