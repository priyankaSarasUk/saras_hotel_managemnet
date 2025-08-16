@extends('layout.app')

@section('content')
<div class="container mt-5">
    <h2>Edit Booking</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('bookings.update', $booking->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <label>Customer</label>
        <select name="customer_id" required class="form-control mb-3">
            <option value="">Select Customer</option>
            @foreach($customers as $customer)
                <option value="{{ $customer->id }}" {{ old('customer_id', $booking->customer_id) == $customer->id ? 'selected' : '' }}>
                    {{ $customer->name }}
                </option>
            @endforeach
        </select>

        <label>Room</label>
        <select name="room_id" required class="form-control mb-3">
            <option value="">Select Room</option>
            @foreach($rooms as $room)
                <option value="{{ $room->id }}" {{ old('room_id', $booking->room_id) == $room->id ? 'selected' : '' }}>
                    {{ $room->room_number }} - {{ $room->room_name }}
                </option>
            @endforeach
        </select>

        <label>Booking Date</label>
        <input type="date" name="booking_date" value="{{ old('booking_date', $booking->booking_date) }}" required class="form-control mb-3">

        <label>Checkout Date</label>
        <input type="date" name="checkout_date" value="{{ old('checkout_date', $booking->checkout_date) }}" required class="form-control mb-3">

        <label>Members</label>
        <input type="number" name="members" value="{{ old('members', $booking->members) }}" min="1" required class="form-control mb-3">

        <label>Adults</label>
        <input type="number" name="adults" value="{{ old('adults', $booking->adults) }}" min="1" required class="form-control mb-3">

        <label>Childs</label>
        <input type="number" name="childs" value="{{ old('childs', $booking->childs) }}" min="0" required class="form-control mb-3">

        <label>Amount</label>
        <input type="number" step="0.01" name="amount" value="{{ old('amount', $booking->amount) }}" required class="form-control mb-3">

        <label>ID Upload(s)</label>
        <input type="file" name="id_uploads[]" multiple class="form-control mb-3">

        @if($booking->id_uploads)
            <p>Existing uploads:</p>
            <ul>
                @foreach($booking->id_uploads as $file)
                    <li><a href="{{ asset('storage/' . $file) }}" target="_blank">{{ basename($file) }}</a></li>
                @endforeach
            </ul>
        @endif

        <button type="submit" class="btn btn-primary">Update Booking</button>
        <a href="{{ route('bookings.index') }}" class="btn btn-secondary ms-2">Cancel</a>
    </form>
</div>
@endsection
