<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'name',
    'email',
    'password',
    'user_type',
    'phone',
    'profile_photo',
    'parent_id',
    'relationship_to_student',
    'student_number',
    'program_id',
    'level_id',
    'enrollment_year',
    'employee_number',
    'department_id',
    'is_active',
])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
            'enrollment_year' => 'integer',
        ];
    }

    /**
     * Relationships
     */
    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class, 'program_id', 'id');
    }

    public function level(): BelongsTo
    {
        return $this->belongsTo(Level::class, 'level_id', 'id');
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }

    // Parent relationship (for students - get their parent)
    public function parent(): BelongsTo
    {
        return $this->belongsTo(User::class, 'parent_id', 'id')
            ->where('user_type', 'parent');
    }

    // Children relationship (for parents - get their children/students)
    public function children(): HasMany
    {
        return $this->hasMany(User::class, 'parent_id', 'id')
            ->where('user_type', 'student');
    }

    // Departments where this user is the head
    public function headedDepartment(): HasMany
    {
        return $this->hasMany(Department::class, 'head_id', 'id');
    }

    // Attendance records (for students)
    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class, 'student_id', 'id');
    }

    // Timetables where this user is the lecturer
    public function timetablesAsLecturer(): HasMany
    {
        return $this->hasMany(Timetable::class, 'id', 'id');
    }

    // Notifications
    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class, 'user_id', 'id');
    }

    // Location logs
    public function locationLogs(): HasMany
    {
        return $this->hasMany(LocationLog::class, 'user_id', 'id');
    }

    /**
     * Scopes
     */
    public function scopeStudents($query)
    {
        return $query->where('user_type', 'student');
    }

    public function scopeLecturers($query)
    {
        return $query->where('user_type', 'lecturer');
    }

    public function scopeAdmins($query)
    {
        return $query->where('user_type', 'admin');
    }

    public function scopeParents($query)
    {
        return $query->where('user_type', 'parent');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeInactive($query)
    {
        return $query->where('is_active', false);
    }

    /**
     * Helper methods
     */
    public function isStudent(): bool
    {
        return $this->user_type === 'student';
    }

    public function isLecturer(): bool
    {
        return $this->user_type === 'lecturer';
    }

    public function isAdmin(): bool
    {
        return $this->user_type === 'admin';
    }

    public function isParent(): bool
    {
        return $this->user_type === 'parent';
    }

    /**
     * Accessors
     */
    public function getLevelNameAttribute(): string
    {
        return $this->level ? $this->level->name : 'N/A';
    }

    public function getProgramNameAttribute(): string
    {
        return $this->program ? $this->program->name : 'N/A';
    }

    public function getDepartmentNameAttribute(): string
    {
        return $this->department ? $this->department->name : 'N/A';
    }

    public function getFullNameAttribute(): string
    {
        return $this->name;
    }

    public function getProfilePhotoUrlAttribute(): string
    {
        if ($this->profile_photo) {
            return asset('storage/' . $this->profile_photo);
        }
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=0078D4&color=fff';
    }

    /**
     * Get attendance percentage for students
     */
    public function getAttendancePercentageAttribute(): float
    {
        $total = $this->attendances()->count();
        if ($total === 0) {
            return 0;
        }
        
        $present = $this->attendances()
            ->whereIn('status', ['present', 'late'])
            ->count();
        
        return round(($present / $total) * 100, 2);
    }

    /**
     * Get parent's children attendance summary
     */
    public function getChildrenAttendanceSummaryAttribute()
    {
        return $this->children()
            ->withCount(['attendances as total_attendance'])
            ->withCount(['attendances as present_attendance' => function ($query) {
                $query->whereIn('status', ['present', 'late']);
            }])
            ->get()
            ->map(function ($child) {
                $child->attendance_percentage = $child->total_attendance > 0 
                    ? round(($child->present_attendance / $child->total_attendance) * 100, 2) 
                    : 0;
                return $child;
            });
    }
}