<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'name',
    'code',
    'head_id',
    'description',
    'is_active',
])]
class Department extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function programs(): HasMany
    {
        return $this->hasMany(Program::class, 'department_id', 'id');
    }

    public function courses(): HasMany
    {
        return $this->hasMany(Course::class, 'department_id', 'id');
    }

    public function employees(): HasMany
    {
        return $this->hasMany(User::class, 'department_id', 'id')
            ->where('user_type', 'lecturer');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function head()
{
    return $this->belongsTo(User::class, 'head_id');
}

public function students()
{
    return $this->hasMany(User::class, 'department_id')->where('user_type', 'student');
}

public function lecturers()
{
    return $this->hasMany(User::class, 'department_id')->where('user_type', 'lecturer');
}




}