@extends('layout.app')

@section('content')
<div class="container mt-4">
    <h2>Bookings</h2>

    {{-- Success message --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Filters --}}
    <form method="GET" action="{{ route('bookings.index') }}" class="row g-2 mb-3">
        <div class="col-md-3">
            <input type="text" name="customer_name" value="{{ request('customer_name') }}" class="form-control" placeholder="Search by Customer Name">
        </div>
        <div class="col-md-3">
            <input type="date" name="booking_date" value="{{ request('booking_date') }}" class="form-control" placeholder="Booking Date">
        </div>
        <div class="col-md-3">
            <input type="date" name="checkout_date" value="{{ request('checkout_date') }}" class="form-control" placeholder="Checkout Date">
        </div>
        <div class="col-md-3">
            <button class="btn btn-primary w-100" type="submit">Filter</button>
        </div>
    </form>

    <a href="{{ route('bookings.create') }}" class="btn btn-success mb-3">Add Booking</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Customer Name</th>
                <th>Room Number</th>
                <th>Booking Date</th>
                <th>Checkout Date</th>
                <th>Members</th>
                <th>Adults</th>
                <th>Childs</th>
                <th>Amount</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Edit</th>
            </tr>
        </thead>
        <tbody>
            @forelse($bookings as $booking)
                <tr>
                    <td>{{ $booking->customer->name }}</td>
                    <td>{{ $booking->room->room_number }}</td>
                    <td>{{ $booking->booking_date }}</td>
                    <td>{{ $booking->checkout_date }}</td>
                    <td>{{ $booking->members }}</td>
                    <td>{{ $booking->adults }}</td>
                    <td>{{ $booking->childs }}</td>
                    <td>{{ $booking->amount }}</td>
                    <td>{{ $booking->created_at->format('Y-m-d') }}</td>
                    <td>{{ $booking->updated_at->format('Y-m-d') }}</td>
                    <td>
                        <a href="{{ route('bookings.edit', $booking->id) }}" class="btn btn-sm btn-primary">Edit</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="11" class="text-center">No bookings found</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $bookings->links() }}
</div>
@endsection
