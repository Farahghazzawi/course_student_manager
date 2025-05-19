<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;


class ReportController extends Controller
{
    public function index()
    {
        //Gets all courses along with the count of enrolled students.
        $courses = Course::withCount('students')->get(); 
        return view('reports.index', compact('courses'));
    }
}
