@extends('layout.app')

@section('content')
<div class="container">
    <!-- Welcome section -->
    <div class="d-flex align-items-center mb-4">
        <!-- Welcome text -->
        <h2 class="mb-0">Welcome, {{ $user->name }}!</h2>
    </div>

    <h1 class="mb-4">Hotel Dashboard</h1>

    <div class="row">
        <div class="col-md-3">
            <div class="card text-white bg-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Customers</h5>
                    <h3>{{ $totalCustomers }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-white bg-success mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Rooms</h5>
                    <h3>{{ $totalRooms }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-white bg-info mb-3">
                <div class="card-body">
                    <h5 class="card-title">Available Rooms</h5>
                    <h3>{{ $availableRooms }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-white bg-danger mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Bookings</h5>
                    <h3>{{ $totalBookings }}</h3>
                </div>
            </div>
        </div>
    </div>

    <h3 class="mt-4">Recent Bookings</h3>

    <!-- Scrollable table container -->
    <div class="table-container">
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Booking ID</th>
                    <th>Customer</th>
                    <th>Room</th>
                    <th>Check-in</th>
                    <th>Check-out</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentBookings as $booking)
                    <tr>
                        <td>{{ $booking->id }}</td>
                        <td>{{ $booking->customer->name ?? 'N/A' }}</td>
                        <td>{{ $booking->room->room_number ?? 'N/A' }}</td>
                        <td>{{ $booking->check_in }}</td>
                        <td>{{ $booking->check_out }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('styles')
<style>
.table-container {
    max-height: 250px;   /* limit height */
    overflow-y: auto;    /* vertical scroll */
    margin-top: 10px;
}

/* Optional scrollbar styling */
.table-container::-webkit-scrollbar {
    width: 8px;
}
.table-container::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 4px;
}
.table-container::-webkit-scrollbar-thumb:hover {
    background: #555;
}
</style>
@endpush
