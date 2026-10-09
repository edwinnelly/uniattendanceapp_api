<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'department_id',
    'name',
    'code',
    'duration_years',
    'description',
    'is_active',
])]
class Program extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'duration_years' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }

    public function levels(): HasMany
    {
        return $this->hasMany(Level::class, 'program_id', 'id');
    }

    public function students(): HasMany
    {
        return $this->hasMany(User::class, 'program_id', 'id')
            ->where('user_type', 'student');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function getStudentCountAttribute(): int
    {
        return $this->students()->count();
    }
}