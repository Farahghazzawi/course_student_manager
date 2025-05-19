@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Courses</h1>
        <a href="{{ route('courses.create') }}" class="btn btn-primary mb-3">Add New Course</a>
        <a href="{{ url('/') }}" class="btn btn-secondary mb-3">
            ← Back to Welcome Page
        </a>
        

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Course Code</th>
                    <th>Name</th>
                    <th>Credit Hours</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($courses as $course)
                    <tr>
                        <td>{{ $course->course_code }}</td>
                        <td>{{ $course->name }}</td>
                        <td>{{ $course->credit_hours }}</td>
                        <td>
                        <a href="{{ route('courses.show', $course->id) }}" class="btn btn-primary btn-sm">View</a>
                        <a href="{{ route('courses.schedule', $course->id) }}" class="btn btn-secondary btn-sm">Schedule</a>
                        <a href="{{ route('courses.edit', ['course' => $course->id]) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('courses.destroy', ['course' => $course->id]) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </table>
            </tbody>

            <div class="mt-4">
                {{ $courses->links('pagination::bootstrap-4') }}
            </div>
    </div>
    
@endsection
