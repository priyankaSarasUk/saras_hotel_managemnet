@extends('layout.app')

@section('content')
<div class="container mt-5">
    <h1>Edit Room</h1>

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

    <form action="{{ route('rooms.update', $room->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="hotel_name" class="form-label">Hotel Name</label>
            <input type="text" id="hotel_name" name="hotel_name"
                   value="{{ old('hotel_name', $room->hotel_name) }}"
                   required class="form-control">
        </div>

        <div class="mb-3">
            <label for="room_number" class="form-label">Room Number</label>
            <input type="text" id="room_number" name="room_number"
                   value="{{ old('room_number', $room->room_number) }}"
                   required class="form-control">
        </div>

        <div class="mb-3">
            <label for="room_name" class="form-label">Room Name</label>
            <input type="text" id="room_name" name="room_name"
                   value="{{ old('room_name', $room->room_name) }}"
                   required class="form-control">
        </div>

        <div class="mb-3">
            <label for="room_type" class="form-label">Room Type</label>
            <select id="room_type" name="room_type" class="form-control" required>
                <option value="single" {{ $room->room_type == 'single' ? 'selected' : '' }}>Single</option>
                <option value="double" {{ $room->room_type == 'double' ? 'selected' : '' }}>Double</option>
                <option value="triple" {{ $room->room_type == 'triple' ? 'selected' : '' }}>Triple</option>
                <option value="4 bed" {{ $room->room_type == '4 bed' ? 'selected' : '' }}>4 Bed</option>
                <option value="6 bed" {{ $room->room_type == '6 bed' ? 'selected' : '' }}>6 Bed</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Update Room</button>
        <a href="{{ route('rooms.index') }}" class="btn btn-secondary">Cancel</a>

    </form>
</div>
@endsection
