@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-secondary text-white">
            <h4 class="mb-0">Available Courses for {{ $student->first_name }} {{ $student->last_name }}</h4>
        </div>
        <div class="card-body">
            @if($courses->isEmpty())
                <p class="text-muted">No available courses to register.</p>
            @else
                <ul class="list-group">
                    @foreach($courses as $course)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <strong>{{ $course->name }}</strong><br>
                                <small class="text-muted">{{ $course->description }}</small>
                            </div>
                            <form action="{{ route('students.course.register', [$student->id, $course->id]) }}" method="POST">
                                <!-- Protects the form from CSRF attacks (security requirement in Laravel) -->
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">Register</button>
                            </form>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
        <div class="card-footer text-end">
            <a href="{{ route('students.courses.registered', $student->id) }}" class="btn btn-secondary">Back to Registered Courses</a>
        </div>
    </div>
</div>
@endsection
