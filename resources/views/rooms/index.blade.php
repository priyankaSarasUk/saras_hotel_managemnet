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
        </div>
    </form>

    <!-- Add Room Button -->
    <a href="{{ route('rooms.create') }}" class="btn btn-success mb-3"> Add Room</a>

    @if($rooms->isEmpty())
        <div class="alert alert-info">No rooms found.</div>
    @else

        {{-- ================= Desktop View (Table) ================= --}}
        <div class="d-none d-md-block">
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
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
                            <form action="{{ route('rooms.destroy', $room->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm" type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- ================= Mobile View (Cards) ================= --}}
        <div class="d-block d-md-none">
            <style>
                .room-card {
                    background: #fff;
                    border: 1px solid #e5e7eb;
                    border-radius: 14px;
                    box-shadow: 0 1px 6px rgba(17,24,39,.08);
                    padding: 12px;
                    margin-bottom: 12px;
                }
                .room-head {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    margin-bottom: 6px;
                }
                .room-name {
                    font-weight: 700;
                    font-size: 16px;
                    color: #111827;
                }
                .room-sub {
                    font-size: 13px;
                    color: #6b7280;
                    margin-bottom: 8px;
                }
                .dropdown-toggle::after {
                    display: none;
                }
            </style>

            <div class="row">
                @foreach($rooms as $room)
                    <div class="col-12">
                        <div class="room-card">
                            <div class="room-head">
                                <div class="room-name">Room {{ $room->room_number }}</div>

                                {{-- Three-dot menu --}}
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-light dropdown-toggle" type="button" id="dropdownMenuButton{{ $room->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                        &#x22EE;
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton{{ $room->id }}">
                                        <li><a class="dropdown-item" href="{{ route('rooms.edit', $room->id) }}">Edit</a></li>
                                        <li>
                                            <form action="{{ route('rooms.destroy', $room->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="dropdown-item text-danger" type="submit">Delete</button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="room-sub">
                                <strong>Hotel:</strong> {{ $room->hotel_name }}
                            </div>
                            <div class="room-sub">
                                <strong>Name:</strong> {{ $room->room_name }}
                            </div>
                            <div class="room-sub">
                                <strong>Type:</strong> {{ $room->room_type }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-3">
            {{ $rooms->links() }}
        </div>
    @endif
</div>
@endsection
