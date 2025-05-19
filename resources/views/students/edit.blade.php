@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Student Details</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('students.update', $student->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>First Name</label>
            <input type="text" name="first_name" class="form-control" value="{{ $student->first_name }}" required>
        </div>

        <div class="form-group">
            <label>Middle Name</label>
            <input type="text" name="middle_name" class="form-control" value="{{ $student->middle_name }}">
        </div>

        <div class="form-group">
            <label>Last Name</label>
            <input type="text" name="last_name" class="form-control" value="{{ $student->last_name }}" required>
        </div>

        <div class="form-group">
            <label>Phone</label>
            <input type="text" name="phone" class="form-control" value="{{$student->phone}}">
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ $student->email }}" required>
        </div>

        <div class="form-group">
            <label>Emergency Contact</label> 
            <input type="text" name="emergency_phone_number" class="form-control" value="{{ $student->emergency_phone_number }}" required>
        </div>

        <div class="form-group">
            <label>Date of Birth</label>
            <input type="date" name="date_of_birth" class="form-control" value="{{ $student->date_of_birth }}" required>
        </div>

        <div class="form-group">
            <label>Gender</label>
            <select name="gender" class="form-control" required>
                <option value="">-- Select Gender --</option>
                <option value="male" {{ old('gender', $student->gender) == 'male' ? 'selected' : '' }}>Male</option>
                <option value="female" {{ old('gender', $student->gender) == 'female' ? 'selected' : '' }}>Female</option>
            </select>
        </div>

        <div class="form-group">
            <label>Nationality</label>
            <select name="nationality" class="form-control" required>
                <option value="">-- Select Nationality --</option>
                @php
                    $nationalities = ['Lebanese', 'Syrian', 'Palestinian', 'Jordanian', 'Iraqi', 'Egyptian', 'Other'];
                @endphp
                @foreach ($nationalities as $nationality)
                    <option value="{{ $nationality }}" {{ old('nationality', $student->nationality) == $nationality ? 'selected' : '' }}>
                        {{ $nationality }}
                    </option>
                @endforeach
            </select>    
        </div>

        <div class="form-group">
            <label>Address</label>
            <input type="text" name="address" class="form-control" value="{{ old('address', $student->address) }}">
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('students.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
