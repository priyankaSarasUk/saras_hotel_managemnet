@extends('layout.app')

@section('content')
<div class="container mt-4">
    <h2>Add Booking</h2>

    {{-- Validation Errors --}}
    @if ($errors->any())
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

        {{-- Customer & Room --}}
        <div class="row mb-3">
            <div class="col-md-6">
                <label>Customer Name <span class="text-danger">*</span></label>
                <select name="customer_id" class="form-control" required>
                    <option value="">Select Customer</option>
                    @foreach($customers as $customer)
                        <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                            {{ $customer->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label>Room <span class="text-danger">*</span></label>
                <select name="room_id" class="form-control" required>
                    <option value="">Select Room</option>
                    @foreach($rooms as $room)
                        <option value="{{ $room->id }}" {{ old('room_id') == $room->id ? 'selected' : '' }}>
                            {{ $room->room_number }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- Dates --}}
        <div class="row mb-3">
            <div class="col-md-4">
                <label>Booking Date</label>
                <input type="datetime-local" name="booking_date" class="form-control" value="{{ old('booking_date', now()->format('Y-m-d\TH:i')) }}">
            </div>
            <div class="col-md-4">
                <label>Check In</label>
                <input type="datetime-local" name="check_in" class="form-control" value="{{ old('check_in', now()->format('Y-m-d\TH:i')) }}">
            </div>
            <div class="col-md-4">
                <label>Check Out</label>
                <input type="datetime-local" name="check_out" class="form-control" value="{{ old('check_out', now()->addDay()->setTime(11,0)->format('Y-m-d\TH:i')) }}">
            </div>
        </div>

        {{-- Members --}}
        <div class="row mb-3">
            <div class="col-md-4">
                <label>Male <span class="text-danger">*</span></label>
                <input type="number" name="male" class="form-control" min="0" value="{{ old('male', 1) }}" required>
            </div>
            <div class="col-md-4">
                <label>Female <span class="text-danger">*</span></label>
                <input type="number" name="female" class="form-control" min="0" value="{{ old('female', 0) }}" required>
            </div>
            <div class="col-md-4">
                <label>Children <span class="text-danger">*</span></label>
                <input type="number" name="childs" class="form-control" min="0" value="{{ old('childs', 0) }}" required>
            </div>
        </div>

        {{-- Total Members & Adults (readonly) --}}
        <div class="row mb-3">
            <div class="col-md-6">
                <label>Total Members</label>
                <input type="number" name="members" class="form-control" readonly value="{{ old('members', 1) }}">
            </div>
            <div class="col-md-6">
                <label>Total Adults</label>
                <input type="number" name="adults" class="form-control" readonly value="{{ old('adults', 1) }}">
            </div>
        </div>

        {{-- Relation & Purpose --}}
        <div class="row mb-3">
            <div class="col-md-6">
                <label>Relation with Each Other</label>
                <input type="text" name="relation" class="form-control" placeholder="Family, Friends, etc." value="{{ old('relation') }}">
            </div>
            <div class="col-md-6">
                <label>Purpose of Visit</label>
                <input type="text" name="purpose" class="form-control" placeholder="Vacation, Business, etc." value="{{ old('purpose') }}">
            </div>
        </div>

        {{-- Arrival & Vehicle --}}
        <div class="row mb-3">
            <div class="col-md-6">
                <label>Arrival From</label>
                <input type="text" name="arrival_from" class="form-control" placeholder="City / Location" value="{{ old('arrival_from') }}">
            </div>
            <div class="col-md-6">
                <label>Vehicle Number (Optional)</label>
                <input type="text" name="vehicle_number" class="form-control" placeholder="AB12CD3456" value="{{ old('vehicle_number') }}">
            </div>
        </div>

        {{-- Amount --}}
        <div class="row mb-3">
            <div class="col-md-6">
                <label>Amount <span class="text-danger">*</span></label>
                <input type="number" name="amount" class="form-control" min="0" value="{{ old('amount', 0) }}" required>
            </div>
        </div>

        {{-- ID Uploads --}}
        <div class="row mb-3">
            <div class="col-md-6">
                <label>ID Front (Optional)</label>
                <input type="file" name="id_front[]" class="form-control" multiple>
            </div>
            <div class="col-md-6">
                <label>ID Back (Optional)</label>
                <input type="file" name="id_back[]" class="form-control" multiple>
            </div>
        </div>

        <button type="submit" class="btn btn-success">Save Booking</button>
    </form>
</div>

{{-- Auto-calculate totals --}}
<script>
    const maleInput = document.querySelector('input[name="male"]');
    const femaleInput = document.querySelector('input[name="female"]');
    const childsInput = document.querySelector('input[name="childs"]');
    const membersOutput = document.querySelector('input[name="members"]');
    const adultsOutput = document.querySelector('input[name="adults"]');

    function updateTotals() {
        const male = parseInt(maleInput.value) || 0;
        const female = parseInt(femaleInput.value) || 0;
        const childs = parseInt(childsInput.value) || 0;

        membersOutput.value = male + female + childs;
        adultsOutput.value = male + female;
    }

    maleInput.addEventListener('input', updateTotals);
    femaleInput.addEventListener('input', updateTotals);
    childsInput.addEventListener('input', updateTotals);

    window.addEventListener('load', updateTotals);
</script>
@endsection
