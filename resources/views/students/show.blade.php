@extends('layouts.app')
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
@section('content')
<div class="container">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h2 class="mb-0">Student Details</h2>
        </div>
        
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label font-weight-bold">First Name:</label>
                        <div class="col-sm-8">
                            <p class="form-control-plaintext border-bottom">{{ $student->first_name ?? 'N/A' }}</p>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label font-weight-bold">Middle Name:</label>
                        <div class="col-sm-8">
                            <p class="form-control-plaintext border-bottom">{{ $student->middle_name ?? 'N/A' }}</p>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label font-weight-bold">Last Name:</label>
                        <div class="col-sm-8">
                            <p class="form-control-plaintext border-bottom">{{ $student->last_name ?? 'N/A' }}</p>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label font-weight-bold">Date of Birth:</label>
                        <div class="col-sm-8">
                            <p class="form-control-plaintext border-bottom">
                                {{ $student->date_of_birth ? \Carbon\Carbon::parse($student->date_of_birth)->format('d-m-Y') : 'N/A' }}
                            </p>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label font-weight-bold">Gender:</label>
                        <div class="col-sm-8">
                            <p class="form-control-plaintext border-bottom">{{ $student->gender ? ucfirst($student->gender) : 'N/A' }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label font-weight-bold">Email:</label>
                        <div class="col-sm-8">
                            <p class="form-control-plaintext border-bottom">{{ $student->email ?? 'N/A' }}</p>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label font-weight-bold">Phone:</label>
                        <div class="col-sm-8">
                            <p class="form-control-plaintext border-bottom">{{ $student->phone ?? 'N/A' }}</p>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label font-weight-bold">Emergency Contact:</label>
                        <div class="col-sm-8">
                            <p class="form-control-plaintext border-bottom">{{ $student->emergency_phone_number ?? 'N/A' }}</p>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label font-weight-bold">Nationality:</label>
                        <div class="col-sm-8">
                            <p class="form-control-plaintext border-bottom">{{ $student->nationality ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <label class="font-weight-bold">Address:</label>
                <p class="form-control-plaintext border-bottom">{{ $student->address ?? 'N/A' }}</p>
            </div>
            
            <div class="mt-4">
                <a href="{{ route('students.courses.registered', $student->id) }}" class="btn btn-primary">
                    <i class="fas fa-arrow-left"></i> Registered Courses
                </a>
                <a href="{{ route('students.courses.available', $student->id) }}" class="btn btn-success">
                    <i class="fas fa-arrow-left"></i> Register a New Course
                </a>
                <a href="{{ route('students.edit', $student->id) }}" class="btn btn-warning">
                    <i class="fas fa-arrow-left"></i> Edit
                </a>


                <!-- Delete Button -->
                <form action="{{ route('students.destroy', $student->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger"
                            onclick="return confirm('Are you sure you want to delete this student?')">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                </form>

                <a href="{{ route('students.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to List
                </a>
            </div>

        </div>
    </div>
</div>
@endsection