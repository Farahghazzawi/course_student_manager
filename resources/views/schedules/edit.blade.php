@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Schedule for {{ $schedule->course->name }}</h2>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('courses.schedules.update', $schedule->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Day of Week</label>
            <select name="day_of_week" class="form-control" required>
                @foreach(['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'] as $day)
                    <option value="{{ $day }}" @if($schedule->day_of_week === $day) selected @endif>{{ $day }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group mt-2">
            <label>Start Time</label>
            <input type="time" name="start_time" value="{{ $schedule->start_time }}" class="form-control" required>
        </div>
        <div class="form-group mt-2">
            <label>End Time</label>
            <input type="time" name="end_time" value="{{ $schedule->end_time }}" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Update Schedule</button>
        <a href="{{ route('courses.schedule', $schedule->course_id) }}" class="btn btn-secondary mt-3">Back</a>
    </form>
</div>
@endsection
