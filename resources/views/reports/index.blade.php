@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <!-- Back Button -->
    <a href="{{ url()->previous() }}" class="btn btn-secondary mb-3">
        ← Back
    </a>

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Course Enrollment Report</h4>
        </div>
        <div class="card-body">
            @if($courses->isEmpty())
                <p class="text-muted">No courses found.</p>
            @else
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Course Name</th>
                            <th>Enrolled Students</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($courses as $course)
                        <tr>
                            <td>{{ $course->name }}</td>
                            <td>{{ $course->students_count }}</td>
                            <td>
                                <a href="{{ route('courses.students.enrolled', $course->id) }}" class="btn btn-sm btn-outline-primary">View Students</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>
@endsection
