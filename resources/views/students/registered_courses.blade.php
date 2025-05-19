@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-success text-white">
            <h4 class="mb-0">Registered Courses for {{ $student->first_name }} {{ $student->last_name }}</h4>
        </div>
        <div class="card-body">
            @if($courses->isEmpty())
                <p class="text-muted">No registered courses.</p>
            @else
                <ul class="list-group">
                    @foreach($courses as $course)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <strong>{{ $course->name }}</strong><br>
                                <small class="text-muted">{{ $course->description }}</small>
                            </div>
                            <form action="{{ route('students.course.unregister', [$student->id, $course->id]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Unregister</button>
                            </form>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
        <div class="card-footer text-end">
            <a href="{{ route('students.courses.available', $student->id) }}" class="btn btn-success">Register a New Course</a>
            <a href="{{ route('student.schedule', $student->id) }}" class="btn btn-secondary">Back</a>
        </div>
    </div>
</div>
@endsection
