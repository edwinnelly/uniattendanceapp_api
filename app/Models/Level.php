<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    protected $fillable = [
        'program_id',
        'name',
        'code',
        'level_order',
        'description',
    ];

    protected $casts = [
        'level_order' => 'integer',
    ];

    // Relationships
    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function students()
    {
        return $this->hasMany(User::class, 'level_id')->where('user_type', 'student');
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    public function timetables()
    {
        return $this->hasMany(Timetable::class);
    }
}