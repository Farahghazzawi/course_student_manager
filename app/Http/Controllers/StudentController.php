<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller 
{
    public function index()
    {
        $students = Student::latest()->paginate(5);

        return view('students.index', compact('students'));
    }

    public function create()
    {
        return view('students.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:students,email',
            'phone' => 'nullable|string|max:20',
            'date_of_birth' => 'required|date|before:' . (new \DateTime())->modify('-5 years')->format('Y-m-d'),
            'gender' => 'required|in:male,female', //Restriction here
            'emergency_phone_number' => 'required|string|max:20',
            'address' => 'nullable|string',
            'nationality' => 'required|string|max:30',
        ]);

        Student::create($request->all());

        return redirect()->route('students.index')->with('success', 'New student added successfully!');
    }

    public function show($id)
    {
        $student = Student::findOrFail($id);
        return view('students.show', compact('student'));
    }

    public function edit($id)
    {
        $student = Student::findOrFail($id);
        return view('students.edit', compact('student')); // ✅ Add this
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:students,email,' . $id,
            'phone' => 'nullable|string|max:20',
            'date_of_birth' => 'required|date|before:' . (new \DateTime())->modify('-5 years')->format('Y-m-d'),
            'gender' => 'required|in:male,female',
            'emergency_phone_number' => 'required|string|max:20',
            'address' => 'nullable|string',
            'nationality' => 'required|string|max:30',
        ]);

        $student = Student::findOrFail($id);
        $student->update($request->all()); 

        return redirect()->route('students.index')->with('success', 'Student details updated successfully!');
    }

    public function destroy($id)
    {
        $student = Student::findOrFail($id);
        $student->delete();

        return redirect()->route('students.index')->with('success', 'Student deleted successfully.');
    }

    //Registration part3
    //This function retrieves all registered courses
    public function registeredCourses(Student $student){
        // Fetch all courses the student is registered for using the 
        // 'belongsToMany' relationship defined in the model.
        $courses = $student->courses; 

        // Creates an array of variables ('student' and 'courses') to pass to the view,
        // so that the student's details and their registered courses can be displayed.
        return view('students.registered_courses', compact('student', 'courses'));
    }

    //This function retrieves all unregistered courses
    public function availableCourses(Student $student){
        // Fetch all courses that the student is NOT registered usind the id
        $courses = Course::whereNotIn('id', $student->courses->pluck('id'))->get();

        return view('students.available_courses', compact('student','courses'));
    }

    public function registerCourse (Student $student,Course $course){
        // Retrieve the student's courses using the courses() relationship.
        // Use contains() to check if the student is already registered in the course.
        // If not, attach() is used to add the course to the pivot table (course_student).
        if (!$student->courses->contains($course->id)){
            $student->courses()->attach($course->id);
        }

        return redirect()->route('students.courses.registered', $student->id)
        ->with('success','Course registered successfully');
    }

    public function unregisterCourse(Student $student, Course $course) {

        if ($student->courses->contains($course->id)){
            $student->courses()->detach($course->id);
        }

        return redirect()->route('students.courses.registered', $student->id)
        ->with('success','Course unregistered successfully');

    }

    public function showSchedule(Student $student)
    {
        $courses = $student->courses()->with('schedules')->get();

        $schedules = collect();
        foreach ($courses as $course) {
            foreach ($course->schedules as $schedule) {
                $schedule->course_name = $course->name;
                $schedules->push($schedule);
            }
        }

        return view('students.schedule', compact('student', 'schedules'));
    }

}