@extends('layout.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Rooms List</h1>

    <!-- Search / Filter Form -->
    <form method="GET" action="{{ route('rooms.index') }}" class="row g-2 mb-4">
        <div class="col-md-3">
            <input type="text" name="hotel_name" class="form-control" placeholder="Search by Hotel" value="{{ request('hotel_name') }}">
        </div>
        <div class="col-md-3">
            <input type="text" name="room_number" class="form-control" placeholder="Search by Room Number" value="{{ request('room_number') }}">
        </div>
        <div class="col-md-3">
            <input type="text" name="room_type" class="form-control" placeholder="Search by Room Type" value="{{ request('room_type') }}">
        </div>
        <div class="col-md-3 d-flex">
            <button type="submit" class="btn btn-primary me-2">Search</button>
            <!-- <a href="{{ route('rooms.index') }}" class="btn btn-secondary">Reset</a> -->
        </div>
    </form>

    <!-- Add Room Button -->
    <a href="{{ route('rooms.create') }}" class="btn btn-success mb-3"> Add Room</a>

    @if($rooms->isEmpty())
        <div class="alert alert-info">No rooms found.</div>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Hotel</th>
                    <th>Room Number</th>
                    <th>Room Name</th>
                    <th>Type</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($rooms as $room)
                <tr>
                    <td>{{ $room->id }}</td>
                    <td>{{ $room->hotel_name }}</td>
                    <td>{{ $room->room_number }}</td>
                    <td>{{ $room->room_name }}</td>
                    <td>{{ $room->room_type }}</td>
                    <td>
                        <a href="{{ route('rooms.edit', $room->id) }}" class="btn btn-warning btn-sm">Edit</a>

                        <form action="{{ route('rooms.destroy', $room->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Are you sure?')" class="btn btn-danger btn-sm">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination -->
        <div>
            {{ $rooms->links() }}
        </div>
    @endif
</div>
@endsection
