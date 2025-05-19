@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-secondary text-white">
            <h4 class="mb-0">Available Students for {{ $course->name }}</h4>
        </div>
        <div class="card-body">
            @if($students->isEmpty())
                <p class="text-muted">No available students to enroll.</p>
            @else
                <ul class="list-group">
                    @foreach($students as $student)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <strong>{{ $student->first_name }} {{ $student->last_name }}</strong><br>
                                <small class="text-muted">{{ $student->email }}</small>
                            </div>
                            <form action="{{ route('courses.student.enroll', [$course->id, $student->id]) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">Enroll</button>
                            </form>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
        <div class="card-footer text-end">
            <a href="{{ route('students.courses.registered', $student->id) }}" class="btn btn-secondary">Back to Enrolled Students</a>
        </div>
    </div>
</div>
@endsection
