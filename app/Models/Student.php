<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable =['id','first_name','middle_name', 'last_name', 'email',
    'phone_number','date_of_birth','gender','emergency_phone_number',
    'address','nationality'];

    public function courses(){
        return $this->belongsToMany(Course::class);
    }
    
}
