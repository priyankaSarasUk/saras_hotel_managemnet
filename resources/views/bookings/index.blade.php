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
            <input type="text" name="phone" value="{{ request('phone') }}" class="form-control" placeholder="Phone">
        </div>
        <div class="col-md-3">
            <input type="date" name="booking_date" value="{{ request('booking_date') }}" class="form-control">
        </div>
        <div class="col-md-3">
            <button type="submit" class="btn btn-primary w-100">Search</button>
        </div>
    </form>

    <a href="{{ route('bookings.create') }}" class="btn btn-success mb-3">Add Booking</a>

    <div class="row">
        @forelse($bookings as $booking)
            <div class="col-md-4 mb-3">
                <div class="card shadow-sm border-0 h-100 bg-dark text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <h5 class="card-title mb-3">Customer: {{ $booking->customer->name }}</h5>
                            <!-- Three dot menu -->
                            <div class="dropdown">
                                <button class="btn btn-sm btn-light" type="button" id="dropdownMenuButton{{ $booking->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                    &#x22EE;
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $booking->id }}">
                                    <li><a class="dropdown-item" href="{{ route('bookings.show', $booking->id) }}">View</a></li>
                                    <li><a class="dropdown-item" href="{{ route('bookings.edit', $booking->id) }}">Edit</a></li>
                                    <li>
                                        <form action="{{ route('bookings.destroy', $booking->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="dropdown-item text-danger" type="submit">Delete</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <p class="mb-1"><strong>Room:</strong> {{ $booking->room->room_number ?? 'N/A' }}</p>
                        <p class="mb-1"><strong>Booking Date:</strong> {{ \Carbon\Carbon::parse($booking->booking_date)->format('Y-m-d H:i') }}</p>
                        <p class="mb-1"><strong>Check In:</strong> {{ \Carbon\Carbon::parse($booking->check_in)->format('Y-m-d H:i') }}</p>
                        <p class="mb-1"><strong>Check Out:</strong> {{ \Carbon\Carbon::parse($booking->checkout_date)->format('Y-m-d H:i') }}</p>
                        <p class="mb-1"><strong>Amount:</strong> {{ $booking->amount }}</p>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center">No bookings found</div>
            </div>
        @endforelse
    </div>

    <div class="d-flex justify-content-center">
        {{ $bookings->links() }}
    </div>
</div>
@endsection
