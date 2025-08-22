@extends('layout.app')

@section('content')
<div class="container mt-4">
    <h2>Booking Details</h2>

    {{-- Success message --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <tr>
            <th>Customer Name</th>
            <td>{{ $booking->customer->name }}</td>
        </tr>
        <tr>
            <th>Room Number</th>
            <td>{{ $booking->room->room_number ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>Check In</th>
            <td>{{ $booking->check_in }}</td>
        </tr>
        <tr>
            <th>Check Out</th>
            <td>{{ $booking->check_out }}</td>
        </tr>
        <tr>
            <th>Members</th>
            <td>{{ $booking->members }}</td>
        </tr>
        <tr>
            <th>Adults</th>
            <td>{{ $booking->adults }}</td>
        </tr>
        <tr>
            <th>Children</th>
            <td>{{ $booking->childs }}</td>
        </tr>
        <tr>
            <th>Amount</th>
            <td>{{ $booking->amount }}</td>
        </tr>
        <tr>
            <th>Created At</th>
            <td>{{ $booking->created_at->format('Y-m-d H:i') }}</td>
        </tr>
        <tr>
            <th>Updated At</th>
            <td>{{ $booking->updated_at->format('Y-m-d H:i') }}</td>
        </tr>
        @if($booking->id_front)
            <tr>
                <th>Front ID</th>
                <td>
                    @foreach($booking->id_front as $file)
                        <a href="{{ asset('storage/'.$file) }}" target="_blank">View</a><br>
                    @endforeach
                </td>
            </tr>
        @endif
        @if($booking->id_back)
            <tr>
                <th>Back ID</th>
                <td>
                    @foreach($booking->id_back as $file)
                        <a href="{{ asset('storage/'.$file) }}" target="_blank">View</a><br>
                    @endforeach
                </td>
            </tr>
        @endif
    </table>

    <a href="{{ route('bookings.index') }}" class="btn btn-secondary">Back to Bookings</a>
    <a href="{{ route('bookings.edit', $booking->id) }}" class="btn btn-primary">Edit Booking</a>
</div>
@endsection
