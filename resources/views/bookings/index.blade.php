@extends('layout.app')

@section('content')
<div class="container mt-4">
    <h2>Bookings</h2>

    {{-- Success message --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Filter Section --}}
    <form action="{{ route('bookings.index') }}" method="GET" class="mb-3 row g-2">
        <div class="col-md-3">
            <input type="text" name="customer_name" value="{{ request('customer_name') }}" class="form-control" placeholder="Customer Name">
        </div>
        <div class="col-md-3">
            {{-- Corrected name to booking_date to match controller --}}
            <input type="date" name="booking_date" value="{{ request('booking_date') }}" class="form-control" placeholder="Booking Date">
        </div>
        <div class="col-md-3">
            {{-- Corrected name to checkout_date to match controller --}}
            <input type="date" name="checkout_date" value="{{ request('checkout_date') }}" class="form-control" placeholder="Check Out">
        </div>
        <div class="col-md-3">
            <button type="submit" class="btn btn-primary w-100">Search</button>
        </div>
    </form>

    <a href="{{ route('bookings.create') }}" class="btn btn-success mb-3">Add Booking</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Customer</th>
                <th>Room</th>
                {{-- Display both booking and check-in dates --}}
                <th>Booking Date</th>
                <th>Check In</th>
                <th>Check Out</th>
                {{-- Corrected headers to match database columns --}}
                <th>Male</th>
                <th>Female</th>
                <th>Children</th>
                <th>Members</th>
                <th>Adults</th>
                <th>Relation</th>
                <th>Purpose</th>
                <th>Arrival From</th>
                <th>Vehicle</th>
                <th>Amount</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($bookings as $booking)
                <tr>
                    <td>{{ $booking->customer->name }}</td>
                    <td>{{ $booking->room->room_number ?? 'N/A' }}</td>
                    <td>{{ \Carbon\Carbon::parse($booking->booking_date)->format('Y-m-d H:i') }}</td>
                    <td>{{ \Carbon\Carbon::parse($booking->check_in)->format('Y-m-d H:i') }}</td>
                    <td>{{ \Carbon\Carbon::parse($booking->checkout_date)->format('Y-m-d H:i') }}</td>
                    {{-- Corrected data to match database columns --}}
                    <td>{{ $booking->male }}</td>
                    <td>{{ $booking->female }}</td>
                    <td>{{ $booking->childs }}</td>
                    <td>{{ $booking->members }}</td>
                    <td>{{ $booking->adults }}</td>
                    <td>{{ $booking->relation ?? '-' }}</td>
                    <td>{{ $booking->purpose ?? '-' }}</td>
                    <td>{{ $booking->arrival_from ?? '-' }}</td>
                    <td>{{ $booking->vehicle_number ?? '-' }}</td>
                    <td>{{ $booking->amount }}</td>
                    <td class="d-flex gap-1">
                        <a href="{{ route('bookings.show', $booking->id) }}" class="btn btn-sm btn-info">View</a>
                        <a href="{{ route('bookings.edit', $booking->id) }}" class="btn btn-sm btn-primary">Edit</a>
                        <form action="{{ route('bookings.destroy', $booking->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="16" class="text-center">No bookings found</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $bookings->links() }}
    </div>
</div>
@endsection