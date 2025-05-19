@extends('layouts.app')
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
@section('content')
<div class="container">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h2 class="mb-0">Course Details</h2>
        </div>
        
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label font-weight-bold">Course Code:</label>
                        <div class="col-sm-8">
                            <p class="form-control-plaintext border-bottom">{{ $course->course_code ?? 'N/A' }}</p>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label font-weight-bold">Course Name:</label>
                        <div class="col-sm-8">
                            <p class="form-control-plaintext border-bottom">{{ $course->name ?? 'N/A' }}</p>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label font-weight-bold">Description:</label>
                        <div class="col-sm-8">
                            <p class="form-control-plaintext border-bottom">{{ $course->description ?? 'N/A' }}</p>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label font-weight-bold">Credit Hours:</label>
                        <div class="col-sm-8">
                            <p class="form-control-plaintext border-bottom">
                                {{ $course->credit_hours ?? 'N/A' }}
                            </p>
                        </div>
                    </div>
            </div>  
            
            <div class="mt-4">

                <a href="{{ route('courses.students.enrolled', $course->id) }}" class="btn btn-primary">
                    <i class="fas fa-arrow-left"></i> Enrolled Students
                </a>

                <a href="{{ route('courses.students.available', $course->id) }}" class="btn btn-success">
                    <i class="fas fa-arrow-left"></i> Add a Student
                </a>
            </div>

            <div class="mt-4">

                <a href="{{ route('courses.edit', $course->id) }}" class="btn btn-warning">
                    <i class="fas fa-arrow-left"></i> Edit Course Details
                </a>

                    <!-- Delete Button -->
                <form action="{{ route('courses.destroy', $course->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger"
                            onclick="return confirm('Are you sure you want to delete this course?')">
                        <i class="fas fa-trash"></i> Delete Course
                    </button>
                </form>

                <a href="{{ route('courses.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to List
                </a>
            </div>

    </div>
</div>
@endsection