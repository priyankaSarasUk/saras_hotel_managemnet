@extends('layout.app')

@section('content')
<div class="container mt-4">
    <h2>Bookings</h2>

    {{-- Success message --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- 🔹 Filter Section --}}
    <form action="{{ route('bookings.index') }}" method="GET" class="mb-3 row g-2">
        <div class="col-md-3">
            <input type="text" name="customer_name" value="{{ request('customer_name') }}" class="form-control" placeholder="Customer Name">
        </div>
        <div class="col-md-3">
            <input type="date" name="check_in" value="{{ request('check_in') }}" class="form-control" placeholder="Check In">
        </div>
        <div class="col-md-3">
            <input type="date" name="check_out" value="{{ request('check_out') }}" class="form-control" placeholder="Check Out">
        </div>
        <div class="col-md-3">
            <button type="submit" class="btn btn-primary w-100">search</button>
        </div>
    </form>

    <a href="{{ route('bookings.create') }}" class="btn btn-success mb-3">Add Booking</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Customer Name</th>
                <th>Room Number</th>
                <th>Check In</th>
                <th>Check Out</th>
                <th>Members</th>
                <th>Adults</th>
                <th>Children</th>
                <th>Amount</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($bookings as $booking)
                <tr>
                    <td>{{ $booking->customer->name }}</td>
                    <td>{{ $booking->room->room_number ?? 'N/A' }}</td>
                    <td>{{ $booking->check_in }}</td>
                    <td>{{ $booking->check_out }}</td>
                    <td>{{ $booking->members }}</td>
                    <td>{{ $booking->adults }}</td>
                    <td>{{ $booking->childs }}</td>
                    <td>{{ $booking->amount }}</td>
                    <td>{{ $booking->created_at->format('Y-m-d') }}</td>
                    <td>{{ $booking->updated_at->format('Y-m-d') }}</td>
                    <td class="d-flex gap-1">
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
                    <td colspan="11" class="text-center">No bookings found</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Pagination --}}
    <div class="d-flex justify-content-center">
        {{ $bookings->links() }}
    </div>
</div>
@endsection
