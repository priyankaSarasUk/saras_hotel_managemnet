@extends('layout.app')

@section('content')
<div class="container mt-4">
    <h2>Booking Details</h2>

    {{-- Success message --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <tr><th>Customer</th><td>{{ $booking->customer->name }}</td></tr>
        <tr><th>Room</th><td>{{ $booking->room->room_number ?? 'N/A' }}</td></tr>
        {{-- Corrected date fields to match database and controller --}}
        <tr><th>Booking Date</th><td>{{ \Carbon\Carbon::parse($booking->booking_date)->format('Y-m-d H:i') }}</td></tr>
        <tr><th>Check In</th><td>{{ \Carbon\Carbon::parse($booking->check_in)->format('Y-m-d H:i') }}</td></tr>
        <tr><th>Check Out</th><td>{{ \Carbon\Carbon::parse($booking->checkout_date)->format('Y-m-d H:i') }}</td></tr>
        {{-- Corrected member fields to match database --}}
        <tr><th>Male</th><td>{{ $booking->male }}</td></tr>
        <tr><th>Female</th><td>{{ $booking->female }}</td></tr>
        <tr><th>Children</th><td>{{ $booking->childs }}</td></tr>
        <tr><th>Total Members</th><td>{{ $booking->members }}</td></tr>
        <tr><th>Total Adults</th><td>{{ $booking->adults }}</td></tr>
        <tr><th>Relation</th><td>{{ $booking->relation ?? '-' }}</td></tr>
        <tr><th>Purpose</th><td>{{ $booking->purpose ?? '-' }}</td></tr>
        <tr><th>Arrival From</th><td>{{ $booking->arrival_from ?? '-' }}</td></tr>
        <tr><th>Vehicle Number</th><td>{{ $booking->vehicle_number ?? '-' }}</td></tr>
        <tr><th>Amount</th><td>{{ $booking->amount }}</td></tr>
        <tr><th>Created At</th><td>{{ $booking->created_at->format('Y-m-d H:i') }}</td></tr>
        <tr><th>Updated At</th><td>{{ $booking->updated_at->format('Y-m-d H:i') }}</td></tr>

        @if($booking->id_front)
            <tr>
                <th>ID Front</th>
                <td>
                    @foreach($booking->id_front as $file)
                        <a href="{{ asset('storage/'.$file) }}" target="_blank">View</a><br>
                    @endforeach
                </td>
            </tr>
        @endif

        @if($booking->id_back)
            <tr>
                <th>ID Back</th>
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