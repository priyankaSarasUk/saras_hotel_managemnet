@extends('layout.app')

@section('content')
<div class="container">
    <!-- Welcome section -->
    <div class="d-flex align-items-center mb-4">
        <h2 class="mb-0">Welcome, {{ $user->name }}!</h2>
    </div>

    <h1 class="mb-4">Hotel Dashboard</h1>

    <!-- Dashboard cards -->
    <div class="row">
        <div class="col-6 col-md-3 mb-3">
            <div class="card text-white bg-primary dashboard-card">
                <div class="card-body">
                    <h6 class="card-title">Total Customers</h6>
                    <h4>{{ $totalCustomers }}</h4>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3 mb-3">
            <div class="card text-white bg-success dashboard-card">
                <div class="card-body">
                    <h6 class="card-title">Total Rooms</h6>
                    <h4>{{ $totalRooms }}</h4>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3 mb-3">
            <div class="card text-white bg-info dashboard-card">
                <div class="card-body">
                    <h6 class="card-title">Available Rooms</h6>
                    <h4>{{ $availableRooms }}</h4>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3 mb-3">
            <div class="card text-white bg-danger dashboard-card">
                <div class="card-body">
                    <h6 class="card-title">Total Bookings</h6>
                    <h4>{{ $totalBookings }}</h4>
                </div>
            </div>
        </div>
    </div>

    <!-- Active bookings -->
    <h3 class="mt-4">Today's Active Bookings</h3>

    <!-- Desktop table -->
    <div class="table-container d-none d-md-block">
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
                @forelse($todaysBookings as $booking)
                    <tr>
                        <td>{{ $booking->id }}</td>
                        <td>{{ $booking->customer->name ?? 'N/A' }}</td>
                        <td>{{ $booking->room->room_number ?? 'N/A' }}</td>
                        <td>{{ $booking->check_in }}</td>
                        <td>{{ $booking->check_out }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">No active bookings today</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Mobile cards -->
    <div class="d-md-none">
        @forelse($todaysBookings as $booking)
            <div class="card mb-2 shadow-sm">
                <div class="card-body p-2">
                    <p class="mb-1"><strong>Booking ID:</strong> {{ $booking->id }}</p>
                    <p class="mb-1"><strong>Customer:</strong> {{ $booking->customer->name ?? 'N/A' }}</p>
                    <p class="mb-1"><strong>Room:</strong> {{ $booking->room->room_number ?? 'N/A' }}</p>
                    <p class="mb-1"><strong>Check-in:</strong> {{ $booking->check_in }}</p>
                    <p class="mb-0"><strong>Check-out:</strong> {{ $booking->check_out }}</p>
                </div>
            </div>
        @empty
            <p class="text-center text-muted">No active bookings today</p>
        @endforelse
    </div>
</div>
@endsection

@push('styles')
<style>
/* Dashboard cards normal for desktop */
.dashboard-card {
    height: 100px;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
}
.dashboard-card .card-body {
    padding: 0.5rem;
}
.dashboard-card h6 {
    font-size: 0.9rem;
    margin-bottom: 0.3rem;
}
.dashboard-card h4 {
    font-size: 1.4rem;
    margin: 0;
}

/* Mobile-specific adjustments */
@media (max-width: 767px) {
    .dashboard-card {
        height: 70px;       /* smaller height on mobile */
    }
    .dashboard-card h6 {
        font-size: 0.8rem;
    }
    .dashboard-card h4 {
        font-size: 1.2rem;
    }
    .col-6.col-md-3.mb-3 {
        margin-bottom: 0.5rem;
    }
}

/* Scrollable table */
.table-container {
    max-height: 250px;
    overflow-y: auto;
}
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
