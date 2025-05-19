@extends('layouts.app')
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

@section('content')
<div class="container">
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            <h2 class="mb-0">{{ $student->first_name }} {{ $student->last_name }}</h2>
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
                <a href="{{ route('students.courses.registered', $student->id) }}" class="btn btn-info">
                    <i class="fas fa-arrow-left"></i> Registered Courses
                </a>
                <a href="{{ route('students.courses.available', $student->id) }}" class="btn btn-success">
                    <i class="fas fa-arrow-left"></i> Register a New Course
                </a>
                <a href="{{ route('students.edit', $student->id) }}" class="btn btn-warning">
                    <i class="fas fa-arrow-left"></i> Edit
                </a>

                <form action="{{ route('students.destroy', $student->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger"
                            onclick="return confirm('Are you sure you want to delete this student?')">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                </form>

                <a href="{{ route('students.index') }}" class="btn btn-primary">
                    <i class="fas fa-arrow-left"></i> Back to List
                </a>
            </div>
        </div>
    </div>

<div class="card shadow-sm">
    <div class="card-header bg-secondary text-white">
        <h3 class="mb-0">Schedule</h3>
    </div>
    <div class="card-body p-0">
        @if($schedules->isEmpty())
            <div class="p-3">
                <p class="mb-0">No schedule available for this student.</p>
            </div>
        @else
            @php
                // Sort and group schedules
                $dayOrder = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
                $sorted = $schedules->sortBy(function($item) use ($dayOrder) {
                    return array_search($item->day_of_week, $dayOrder) * 10000 +
                           strtotime($item->start_time) +
                           strtotime($item->end_time);
                });
                $grouped = $sorted->groupBy('day_of_week');
            @endphp

            <table class="table table-bordered mb-0">
                <thead class="thead-dark">
                    <tr>
                        <th>Day</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Course</th>
                        <th>Location</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dayOrder as $day)
                        @if ($grouped->has($day))
                            <tr class="table-secondary">
                                <td colspan="5"><strong>{{ $day }}</strong></td>
                            </tr>
                            @foreach ($grouped[$day] as $schedule)
                                <tr>
                                    <td></td>
                                    <td>{{ \Carbon\Carbon::parse($schedule->start_time)->format('h:i A') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($schedule->end_time)->format('h:i A') }}</td>
                                    <td>{{ $schedule->course_name ?? 'N/A' }}</td>
                                    <td>{{ $schedule->location ?? 'N/A' }}</td>
                                </tr>
                            @endforeach
                        @endif
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>


</div>
@endsection
