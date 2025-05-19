<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Student;
use App\Models\Schedule;

class CourseController extends Controller
{
    // Show all courses
    public function index()
    {
        $courses = Course::latest()->paginate(5);
        return view('courses.index', compact('courses'));
    }

    // Show the form to create a new course
    public function create()
    {
        return view('courses.create');
    }

    // Store the new course in the database
    public function store(Request $request)
    {
        $request->validate([
            'course_code'    => 'required|string|max:10|unique:courses,course_code',
            'name'           => 'required|string|max:255',
            'description'    => 'required|string',
            'credit_hours'   => 'required|integer|min:1|max:6',
      ]);
    
        // Save the course
        Course::create($request->all());
    
        return redirect()->route('courses.index')->with('success', 'Course added successfully!');
    }
    

    // Show a specific course (optional - not required if unused)
    public function show($id)
    {
        $course = Course::findOrFail($id);
        return view('courses.show', compact('course'));
        //compact: creates an array from variables to pass data to views
        //code works without compact() just pass an array manually
    }

    // Show the edit form for a specific course
    // public function edit($id)
    // {
    //     $course = Course::findOrFail($id);
    //     return view('courses.edit', compact('course'));
    // }

    public function edit(Course $course)
    {
        return view('courses.edit', compact('course'));
    }

    // Update a specific course
    public function update(Request $request, $id)
    {
        $request->validate([
            'course_code'    => 'required|string|max:10|unique:courses,course_code,' . $id,
            'name'           => 'required|string|max:255',
            'description'    => 'required|string',
            'credit_hours'   => 'required|integer|min:1|max:6',
        ]);
        
        //Safely fetches a course by ID and shows a 404 error if it doesn't exist.
        $course = Course::findOrFail($id);
        $course->update($request->all());
    
        return redirect()->route('courses.index')->with('success', 'Course updated successfully.');
    }
    

    // Delete a course
    public function destroy($id)
    {
        $course = Course::findOrFail($id);
        $course->delete();

        return redirect()->route('courses.index')->with('success', 'Course deleted successfully.');
    }

    //Registration part3
    //This function retrieves all enrolled students
    public function enrolledStudents(Course $course){
        // Fetch all students that are registered for the course
        $students = $course->students; 

        // Creates an array of variables ('student' and 'courses') to pass to the view,
        // so that the student's details and their registered courses can be displayed.
        return view('courses.enrolled_students', compact('course', 'students'));
    }

    //This function retrieves all unenrolled students
    public function availableStudents(Course $course){
        // Fetch all courses that the student is NOT registered usind the id
        $students = Student::whereNotIn('id', $course->students()->pluck('students.id'))->get();
        return view('courses.available_students', compact('course','students'));
    }

    public function enrollStudent(Course $course, Student $student)
    {
        if (!$course->students->contains($student->id)) {
            $course->students()->attach($student->id);
        }

        return redirect()->route('courses.students.enrolled', $course->id)
            ->with('success', 'Student enrolled successfully');
    }


    public function unenrollStudent(Course $course, Student $student) {
        if ($course->students->contains($student->id)){
            $course->students()->detach($student->id);
        }

        return redirect()->route('courses.students.enrolled', $course->id)
        ->with('success','Student unenrolled successfully');
    }


    //Scheduling 
    public function schedule(Course $course)
    {
        $schedules = $course->schedules()->orderBy('day_of_week')->get();
        return view('courses.schedule', compact('course', 'schedules'));
    }

    public function storeSchedule(Request $request, $courseId)
    {$validated = $request->validate([
            'day_of_week' => 'required|array',
            'day_of_week.*' => 'in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'location' => 'required|string|max:255',    
        ]);

        $course = Course::findOrFail($courseId);

        foreach ($validated['day_of_week'] as $day) {
            // Check for overlapping schedules
            $conflict = $course->schedules()->where('day_of_week', $day)
                ->where(function ($q) use ($validated) {
                    $q->whereBetween('start_time', [$validated['start_time'], $validated['end_time']])
                    ->orWhereBetween('end_time', [$validated['start_time'], $validated['end_time']])
                    ->orWhere(function ($q2) use ($validated) {
                        $q2->where('start_time', '<=', $validated['start_time'])
                            ->where('end_time', '>=', $validated['end_time']);
                    });
                })->exists();

            if ($conflict) {
                return back()->with('error', "Schedule conflict on $day.");
            }

            $course->schedules()->create([
                'day_of_week' => $day,
                'start_time' => $validated['start_time'],
                'end_time' => $validated['end_time'],
                'location' => $validated['location'],

            ]);
        }

        return back()->with('success', 'Schedule(s) added successfully.');
    }


    public function editSchedule(Schedule $schedule)
    {
        return view('schedules.edit', compact('schedule'));
    }

    public function updateSchedule(Request $request, Schedule $schedule)
    {
        $request->validate([
            'day_of_week' => 'required|string',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'location' => 'required|string',
        ]);

        // Overlap check similar to store
        $overlap = Schedule::where('course_id', $schedule->course_id)
            ->where('id', '!=', $schedule->id)
            ->where('day_of_week', $request->day_of_week)
            ->where(function ($query) use ($request) {
                $query->whereBetween('start_time', [$request->start_time, $request->end_time])
                    ->orWhereBetween('end_time', [$request->start_time, $request->end_time])
                    ->orWhere(function ($q) use ($request) {
                        $q->where('start_time', '<', $request->start_time)
                        ->where('end_time', '>', $request->end_time);
                    });
            })->exists();

        if ($overlap) {
            return redirect()->back()->with('error', 'Schedule overlaps with another.');
        }

        $schedule->update($request->all());

        return redirect()->route('courses.schedule', $schedule->course_id)->with('success', 'Schedule updated.');
    }

    public function deleteSchedule(Schedule $schedule)
    {
        $schedule->delete();
        return redirect()->back()->with('success', 'Schedule deleted.');
    }

}