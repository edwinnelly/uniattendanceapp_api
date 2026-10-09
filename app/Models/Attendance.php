<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Crypt;

class Attendance extends Model
{
    protected $table = 'attendance';

    protected $fillable = [
        'student_id',
        'timetable_id',
        'clock_in_time',
        'clock_out_time',
        'clock_in_latitude',
        'clock_in_longitude',
        'clock_in_accuracy',
        'distance_meters',
        'status',
        'source',
        'remarks',
    ];

    protected $casts = [
        'clock_in_time' => 'datetime',
        'clock_out_time' => 'datetime',
        'clock_in_latitude' => 'float',
        'clock_in_longitude' => 'float',
        'clock_in_accuracy' => 'float',
        'distance_meters' => 'float',
    ];

    protected $appends = ['encrypted_id'];

    // ==================== RELATIONSHIPS ====================

    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function timetable(): BelongsTo
    {
        return $this->belongsTo(Timetable::class, 'timetable_id');
    }

    // ==================== SCOPES ====================

    public function scopePresent(Builder $query): Builder
    {
        return $query->where('status', 'present');
    }

    public function scopeLate(Builder $query): Builder
    {
        return $query->where('status', 'late');
    }

    public function scopeAbsent(Builder $query): Builder
    {
        return $query->where('status', 'absent');
    }

    public function scopeExcused(Builder $query): Builder
    {
        return $query->where('status', 'excused');
    }

    public function scopeForStudent(Builder $query, $studentId): Builder
    {
        return $query->where('student_id', $studentId);
    }

    public function scopeForTimetable(Builder $query, $timetableId): Builder
    {
        return $query->where('timetable_id', $timetableId);
    }

    public function scopeForDate(Builder $query, $date): Builder
    {
        return $query->whereDate('clock_in_time', $date);
    }

    // ==================== ACCESSORS ====================

    public function getEncryptedIdAttribute(): string
    {
        return Crypt::encrypt($this->id);
    }

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'present' => 'bg-green-100 text-green-700',
            'late' => 'bg-yellow-100 text-yellow-700',
            'absent' => 'bg-red-100 text-red-700',
            'excused' => 'bg-blue-100 text-blue-700',
            default => 'bg-gray-100 text-gray-700',
        };
    }

    public function getClockInFormattedAttribute(): string
    {
        return $this->clock_in_time ? $this->clock_in_time->format('H:i:s') : 'N/A';
    }

    public function getClockOutFormattedAttribute(): string
    {
        return $this->clock_out_time ? $this->clock_out_time->format('H:i:s') : 'Not clocked out';
    }

    public function getDurationAttribute(): string
    {
        if (!$this->clock_out_time) {
            return 'In progress';
        }
        $minutes = $this->clock_in_time->diffInMinutes($this->clock_out_time);
        return $minutes . ' min';
    }

    public function getIsWithinRadiusAttribute(): bool
    {
        if (!$this->timetable || !$this->timetable->location) {
            return false;
        }
        return $this->distance_meters <= $this->timetable->location->radius_meters;
    }

    // ==================== HELPERS ====================

    public function getRouteKey()
    {
        return $this->encrypted_id;
    }

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