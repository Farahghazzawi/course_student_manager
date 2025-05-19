@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Students</h1>
        <a href="{{ route('students.create') }}" class="btn btn-primary mb-3">Add New Student</a>
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
                    <th>Student ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Actions</th> 
                </tr>
            </thead>
            <tbody>
                @foreach ($students as $student) 
                    <tr>
                        <td>{{ $student->id }}</td>
                        <td>{{ $student->first_name }}</td>
                        <td>{{ $student->last_name }}</td>
                        <td>{{ $student->email }}</td>
                        <td>
                            <a href="{{ route('students.show', $student->id) }}" class="btn btn-primary btn-sm">View</a>
                            <a href="{{ route('student.schedule', $student->id) }}" class="btn btn-secondary btn-sm">Schedule</a>
                            <a href="{{ route('students.edit', $student->id) }}" class="btn btn-warning btn-sm">Edit</a>

                            <form action="{{ route('students.destroy', $student->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Are you sure?')">Delete</button>
                            </form>

                        </td>
                    </tr>
                @endforeach
            </tbody> 
        </table>

        <div class="mt-4">
            {{ $students->links('pagination::bootstrap-4') }} 
        </div>
    </div>
@endsection
