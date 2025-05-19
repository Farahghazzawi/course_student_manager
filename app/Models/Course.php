<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    // public $timestamps = false;  // Add this line
    
    protected $fillable = [
        'course_code', 'name', 'description', 'credit_hours',
        'start_time', 'end_time', 'days_of_week'
    ];

    protected $casts = [
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i'
    ];

    //Registration
    public function students(){
        return $this->belongsToMany(Student::class);
    }

    //Scheduling
    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

}