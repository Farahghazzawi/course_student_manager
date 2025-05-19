<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

//Generate standard CRUD routes automatically
Route::resource('courses', 'CourseController');
Route::resource('students', 'StudentController');

// Registring/Unregistring Courses from Students
Route::get('/students/{student}/courses', 'StudentController@registeredCourses')->name('students.courses.registered');
Route::get('/students/{student}/courses/register', 'StudentController@availableCourses')->name('students.courses.available');

Route::post('/students/{student}/courses/{course}/register', 'StudentController@registerCourse')->name('students.course.register');
Route::delete('/students/{student}/courses/{course}/unregister', 'StudentController@unregisterCourse')->name('students.course.unregister');

// Enrolling/Unenrolling Students from Courses
Route::get('/courses/{course}/students', 'CourseController@enrolledStudents')->name('courses.students.enrolled');
Route::get('/courses/{course}/students/enroll', 'CourseController@availableStudents')->name('courses.students.available');

Route::post('/courses/{course}/students/{student}/enroll', 'CourseController@enrollStudent')->name('courses.student.enroll');
Route::delete('/courses/{course}/students/{student}/unenroll', 'CourseController@unenrollStudent')->name('courses.student.unenroll');

//Scheduling
Route::get('/courses/{course}/schedule', 'CourseController@schedule')->name('courses.schedule');
Route::post('/courses/{course}/schedule', 'CourseController@storeSchedule')->name('courses.schedule.store');
Route::get('/schedules/{schedule}/edit', 'CourseController@editSchedule')->name('courses.schedules.edit');
Route::put('/schedules/{schedule}', 'CourseController@updateSchedule')->name('courses.schedules.update');
Route::delete('/schedules/{schedule}', 'CourseController@deleteSchedule')->name('courses.schedules.delete');

// view schedule for students
Route::get('/students/{student}/schedule', 'StudentController@showSchedule')->name('student.schedule');

//Reporting
Route::get('/reports', 'ReportController@index')->name('reports.index');

?>
