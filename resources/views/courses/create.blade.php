@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Add New Course</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('courses.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Course Code</label>
            <input type="text" name="course_code" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Course Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Description</label>
            <textarea name="description" class="form-control"></textarea>
        </div>

        <div class="form-group">
            <label>Credit Hours</label>
            <input type="number" name="credit_hours" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">Add Course</button>
        <a href="{{ route('courses.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
