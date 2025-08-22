@extends('layout.app')

@section('title', 'Add New Room')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Add New Room</h2>

    <!-- Show Validation Errors -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('rooms.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Hotel Name</label>
            <input type="text" name="hotel_name" class="form-control" 
                   value="{{ old('hotel_name') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Room Number</label>
            <input type="text" name="room_number" class="form-control" 
                   value="{{ old('room_number') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Room Name</label>
            <input type="text" name="room_name" class="form-control" 
                   value="{{ old('room_name') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Room Type</label>
            <select name="room_type" class="form-select" required>
                <option value="">-- Select Room Type --</option>
                <option value="single" {{ old('room_type') == 'single' ? 'selected' : '' }}>Single</option>
                <option value="double" {{ old('room_type') == 'double' ? 'selected' : '' }}>Double</option>
                <option value="triple" {{ old('room_type') == 'triple' ? 'selected' : '' }}>Triple</option>
                <option value="4 bed" {{ old('room_type') == '4 bed' ? 'selected' : '' }}>4 Bed</option>
                <option value="6 bed" {{ old('room_type') == '6 bed' ? 'selected' : '' }}>6 Bed</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Save Room</button>
        <a href="{{ route('rooms.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
