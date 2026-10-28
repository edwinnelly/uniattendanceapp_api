<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'department_id',
        'level_id',
        'code',
        'title',
        'credit_hours',
        'description',
        'is_active',
    ];

    protected $casts = [
        'credit_hours' => 'integer',
        'is_active' => 'boolean',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    public function timetables()
    {
        return $this->hasMany(Timetable::class);
    }



public function lecturer()
{
    return $this->belongsTo(User::class, 'id');
}
}