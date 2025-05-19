@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-success text-white">
            <h4 class="mb-0">Enrolled Students for {{ $course->name }}</h4>
        </div>
        <div class="card-body">
            @if($students->isEmpty())
                <p class="text-muted">The class is empty</p>
            @else
                <ul class="list-group">
                    @foreach($students as $student)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <strong>{{ $student->first_name }} {{ $student->last_name }}</strong><br>
                                <small class="text-muted">{{ $student->email }}</small>
                            </div>
                            <form action="{{ route('courses.student.unenroll', [ $course->id,$student->id]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Unenroll</button>
                            </form>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
        <div class="card-footer text-end">
            <a href="{{ route('courses.students.available', $course->id) }}" class="btn btn-success">Enroll a Student</a>
        </div>
    </div>
</div>
@endsection
