@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Course</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('courses.update', $course->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Course Code</label>
            <input type="text" name="course_code" class="form-control" value="{{ $course->course_code }}" required>
        </div>

        <div class="form-group">
            <label>Course Name</label>
            <input type="text" name="name" class="form-control" value="{{ $course->name }}" required>
        </div>

        <div class="form-group">
            <label>Description</label>
            <textarea name="description" class="form-control">{{ $course->description }}</textarea>
        </div>

        <div class="form-group">
            <label>Credit Hours</label>
            <input type="number" name="credit_hours" class="form-control" value="{{ $course->credit_hours }}" required>
        </div>


        <button type="submit" class="btn btn-primary">Update Course</button>
        <a href="{{ route('courses.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
