@extends('layout.app')

@section('content')
<div class="container mt-5">
    <h2>Add Booking</h2>

    {{-- Validation errors --}}
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('bookings.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="customer_id">Customer</label>
            <select id="customer_id" name="customer_id" class="form-control" required>
                <option value="">Select Customer</option>
                @foreach($customers as $customer)
                    <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                        {{ $customer->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="room_id">Room</label>
            <select id="room_id" name="room_id" class="form-control" required>
                <option value="">Select Room</option>
                @foreach($rooms as $room)
                    <option value="{{ $room->id }}" {{ old('room_id') == $room->id ? 'selected' : '' }}>
                        {{ $room->room_number }} - {{ $room->room_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="booking_date">Booking Date</label>
            <input type="date" id="booking_date" name="booking_date" value="{{ old('booking_date') }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="checkout_date">Checkout Date</label>
            <input type="date" id="checkout_date" name="checkout_date" value="{{ old('checkout_date') }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="members">Members</label>
            <input type="number" id="members" name="members" value="{{ old('members', 1) }}" min="1" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="adults">Adults</label>
            <input type="number" id="adults" name="adults" value="{{ old('adults', 1) }}" min="1" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="childs">Childs</label>
            <input type="number" id="childs" name="childs" value="{{ old('childs', 0) }}" min="0" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="amount">Amount</label>
            <input type="number" step="0.01" id="amount" name="amount" value="{{ old('amount') }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="id_front">ID Front Upload(s)</label>
            <input type="file" id="id_front" name="id_front[]" multiple class="form-control" accept=".jpg,.jpeg,.png,.pdf">
            <small class="form-text text-muted">Upload front side of ID(s).</small>
        </div>

        <div class="mb-3">
            <label for="id_back">ID Back Upload(s)</label>
            <input type="file" id="id_back" name="id_back[]" multiple class="form-control" accept=".jpg,.jpeg,.png,.pdf">
            <small class="form-text text-muted">Upload back side of ID(s).</small>
        </div>

        <button type="submit" class="btn btn-primary">Save Booking</button>
    </form>
</div>
@endsection
