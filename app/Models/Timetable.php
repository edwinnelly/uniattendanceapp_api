<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Crypt;

class Timetable extends Model
{
    protected $table = 'timetables';

    protected $fillable = [
        'course_id',
        'lecturer_id',
        'location_id',
        'level_id',
        'date',
        'start_time',
        'end_time',
        'day_of_week',
        'attendance_window_minutes',
        'status',
        'cancel_reason',
    ];

    protected $casts = [
        'date' => 'date',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
        'attendance_window_minutes' => 'integer',
    ];

    // ==================== RELATIONSHIPS ====================

    /**
     * Get the course for this timetable.
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    /**
     * Get the lecturer for this timetable.
     */
    public function lecturer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'lecturer_id');
    }

    /**
     * Get the location for this timetable.
     */
    public function location(): BelongsTo
    {
        return $this->belongsTo(LectureLocation::class, 'location_id');
    }

    /**
     * Get the level for this timetable.
     */
    public function level(): BelongsTo
    {
        return $this->belongsTo(Level::class, 'level_id');
    }

    // ==================== SCOPES ====================

    public function scopeScheduled($query)
    {
        return $query->where('status', 'scheduled');
    }

    public function scopeOngoing($query)
    {
        return $query->where('status', 'ongoing');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }

    public function scopeForDate($query, $date)
    {
        return $query->whereDate('date', $date);
    }

    public function scopeForLecturer($query, $lecturerId)
    {
        return $query->where('lecturer_id', $lecturerId);
    }

    public function scopeForLocation($query, $locationId)
    {
        return $query->where('location_id', $locationId);
    }

    // ==================== ACCESSORS ====================

    /**
     * Get encrypted ID for URL routing.
     */
    public function getEncryptedIdAttribute(): string
    {
        return Crypt::encrypt($this->id);
    }

    /**
     * Get formatted time range.
     */
    public function getTimeRangeAttribute(): string
    {
        return $this->start_time->format('H:i') . ' - ' . $this->end_time->format('H:i');
    }

    /**
     * Get status badge class.
     */
    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'scheduled' => 'bg-blue-100 text-blue-700',
            'ongoing' => 'bg-green-100 text-green-700',
            'completed' => 'bg-gray-100 text-gray-700',
            'cancelled' => 'bg-red-100 text-red-700',
            default => 'bg-gray-100 text-gray-700',
        };
    }

    // ==================== HELPER METHODS ====================

    /**
     * Check if attendance is currently open.
     */
    public function isAttendanceOpen(): bool
    {
        $now = now();
        $start = $this->date->setTimeFrom($this->start_time);
        $windowEnd = $start->copy()->addMinutes($this->attendance_window_minutes);

        return $now->between($start, $windowEnd);
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKey()
    {
        return $this->encrypted_id;
    }

    /**
     * Resolve the model using the encrypted route key.
     */
    public function resolveRouteBinding($value, $field = null)
    {
        try {
            $id = Crypt::decrypt($value);
            return $this->findOrFail($id);
        } catch (\Exception $e) {
            abort(404);
        }
    }
}