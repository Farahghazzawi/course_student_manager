@extends('layouts.app')

@section('content')
<div class="container">

    <h2 class="text-center">Schedules for {{ $course->name }}</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- Add Schedule Form --}}
    <div class="card mb-4">
        <div class="card-header">Add New Schedule</div>
        <div class="card-body">
            <form action="{{ route('courses.schedule.store', $course->id) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Day of Week</label>
                    <select name="day_of_week[]" class="form-control" multiple required>
                        @foreach(['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'] as $day)
                            <option value="{{ $day }}">{{ $day }}</option>
                        @endforeach
                    </select>
                    <small class="form-text text-muted">Hold Ctrl (Windows) or Command (Mac) to select multiple days.</small>

                </div>
                <div class="form-group mt-2">
                    <label>Start Time</label>
                    <input type="time" name="start_time" class="form-control" required>
                </div>
                <div class="form-group mt-2">
                    <label>End Time</label>
                    <input type="time" name="end_time" class="form-control" required>
                </div>
                <div class="form-group mt-2">
                    <label>Location</label>
                    <input type="text" name="location" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary mt-3">Add Schedule</button>
                    <a href="{{ route('courses.index') }}" class="btn btn-secondary mt-3">
                        ← Back to Courses
                    </a>
            </form>
        </div>
    </div>

    {{-- Existing Schedules --}}
    <div class="card mb-4 bg-primary">
    <div class="card-body">
    <h4 class="mb-4 font-weight-bold text-white">📅 Existing Schedules</h4>

    <div class="table-responsive rounded shadow-sm">

        <table class="table table-bordered table-hover bg-white">
            <thead class="thead-light">
                <tr class="text-center">
                    <th>Day</th>
                    <th>Start</th>
                    <th>End</th>
                    <th>Location</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            @php
                $dayOrder = [
                    'Monday' => 1,
                    'Tuesday' => 2,
                    'Wednesday' => 3,
                    'Thursday' => 4,
                    'Friday' => 5,
                    'Saturday' => 6,
                    'Sunday' => 7,
                ];

                $sortedSchedules = $schedules->sortBy(function ($schedule) use ($dayOrder) {
                    return $dayOrder[$schedule->day_of_week] ?? 8;
                });
            @endphp

            @forelse($sortedSchedules as $schedule)
                <tr>
                    <td>{{ $schedule->day_of_week }}</td>
                    <td>{{ \Carbon\Carbon::parse($schedule->start_time)->format('h:i A') }}</td>
                    <td>{{ \Carbon\Carbon::parse($schedule->end_time)->format('h:i A') }}</td>
                    <td>{{ $schedule->location }}</td>
                    <td class="text-center">
                        <a href="{{ route('courses.schedules.edit', $schedule) }}" class="btn btn-sm btn-outline-warning mr-1">
                            ✏️ Edit
                        </a>
                        <form action="{{ route('courses.schedules.delete', $schedule->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">
                                🗑️ Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center text-muted">No schedules yet.</td>
                </tr>
            @endforelse
            </tbody>
            </div>
            </div>
        </table>
    </div>

</div>
@endsection
