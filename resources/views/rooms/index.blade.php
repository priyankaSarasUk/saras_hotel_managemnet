@extends('layout.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Add a New Room</h1>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Validation Errors --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('rooms.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="hotel_name" class="form-label">Hotel Name</label>
            <input type="text" id="hotel_name" name="hotel_name" 
                   value="{{ old('hotel_name') }}" required 
                   class="form-control" placeholder="Enter Hotel Name">
        </div>

        <div class="mb-3">
            <label for="room_number" class="form-label">Room Number</label>
            <input type="text" id="room_number" name="room_number" 
                   value="{{ old('room_number') }}" required 
                   class="form-control" placeholder="Enter Room Number">
        </div>

        <div class="mb-3">
            <label for="room_name" class="form-label">Room Name</label>
            <input type="text" id="room_name" name="room_name" 
                   value="{{ old('room_name') }}" required 
                   class="form-control" placeholder="Enter Room Name">
        </div>

        <div class="mb-3">
            <label for="room_type" class="form-label">Room Type</label>
            <select id="room_type" name="room_type" required class="form-control">
                <option value="" disabled {{ old('room_type') == '' ? 'selected' : '' }}>Select a room type</option>
                <option value="single" {{ old('room_type') == 'single' ? 'selected' : '' }}>Single</option>
                <option value="double" {{ old('room_type') == 'double' ? 'selected' : '' }}>Double</option>
                <option value="triple" {{ old('room_type') == 'triple' ? 'selected' : '' }}>Triple</option>
                <option value="4 bed" {{ old('room_type') == '4 bed' ? 'selected' : '' }}>4 Bed</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary w-100">Add Room</button>
    </form>
</div>
@endsection
