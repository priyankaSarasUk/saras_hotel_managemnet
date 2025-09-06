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

    {{-- ================= Desktop View (Table) ================= --}}
    <div class="d-none d-md-block">
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Customer</th>
                    <th>Room</th>
                    <th>Booking Date</th>
                    <th>Check In</th>
                    <th>Check Out</th>
                    <th>Guests</th>
                    <th>Amount</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bookings as $booking)
                    <tr>
                        <td>{{ $booking->customer->name }}</td>
                        <td>{{ $booking->room->room_number ?? 'N/A' }}</td>
                        <td>{{ \Carbon\Carbon::parse($booking->booking_date)->format('Y-m-d H:i') }}</td>
                        <td>{{ \Carbon\Carbon::parse($booking->check_in)->format('Y-m-d H:i') }}</td>
                        <td>{{ \Carbon\Carbon::parse($booking->check_out)->format('Y-m-d H:i') }}</td>
                        <td>{{ $booking->members }} Guests</td>
                        <td>₹{{ number_format($booking->amount, 2) }}</td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('bookings.show', $booking->id) }}" class="btn btn-sm btn-info">View</a>
                                <a href="{{ route('bookings.edit', $booking->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('bookings.destroy', $booking->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" type="submit">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">No bookings found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- ================= Mobile View (Cards) ================= --}}
    <div class="d-block d-md-none">
        <style>
            .booking-card {
                background: #fff;
                border: 1px solid #e5e7eb;
                border-radius: 14px;
                box-shadow: 0 1px 6px rgba(17,24,39,.08);
                padding: 12px;
                margin-bottom: 12px;
                position: relative;
            }
            .booking-head {
                display: flex;
                justify-content: space-between;
                align-items: baseline;
                margin-bottom: 6px;
            }
            .booking-name {
                font-weight: 700;
                font-size: 16px;
                color: #111827;
                flex: 1;
                overflow: hidden;
                text-overflow: ellipsis;
                white-space: nowrap;
            }
            .booking-amount {
                font-weight: 800;
                color: #111827;
            }
            .booking-sub {
                display: flex;
                flex-wrap: wrap;
                gap: 8px;
                font-size: 13px;
                color: #6b7280;
                margin-bottom: 8px;
            }
            .booking-room {
                font-weight: 600;
                background: #f3f4f6;
                border: 1px solid #e5e7eb;
                padding: 4px 8px;
                border-radius: 999px;
            }
            .booking-badges {
                display: flex;
                gap: 6px;
                flex-wrap: wrap;
                margin-bottom: 8px;
            }
            .booking-badge {
                font-size: 12px;
                padding: 4px 8px;
                border-radius: 999px;
                background: #f3f4f6;
                border: 1px solid #e5e7eb;
                color: #6b7280;
            }
            .booking-hr {
                height: 1px;
                background: linear-gradient(90deg, transparent, #e5e7eb, transparent);
                margin: 8px 0;
            }
            .booking-details {
                display: grid;
                grid-template-columns: 96px 1fr;
                row-gap: 6px;
                column-gap: 8px;
                font-size: 13px;
            }
            .booking-details dt {
                color: #6b7280;
            }
            .booking-details dd {
                margin: 0;
                color: #111827;
            }
            .dropdown-toggle::after {
                display: none;
            }
        </style>

        <div class="row">
            @forelse($bookings as $booking)
                <div class="col-12">
                    <div class="booking-card">
                        {{-- Header with actions --}}
                        <div class="booking-head">
                            <div class="booking-name">{{ $booking->customer->name }}</div>
                            <div class="booking-amount">₹{{ number_format($booking->amount, 2) }}</div>

                            {{-- Three-dot menu --}}
                            <div class="dropdown ms-2">
                                <button class="btn btn-sm btn-light dropdown-toggle" type="button" id="dropdownMenuButton{{ $booking->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                    &#x22EE;
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton{{ $booking->id }}">
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

                        {{-- Sub info --}}
                        <div class="booking-sub">
                            <span class="booking-room">Room {{ $booking->room->room_number ?? 'N/A' }}</span>
                            <span>{{ \Carbon\Carbon::parse($booking->check_in)->format('m/d H:i') }} → {{ \Carbon\Carbon::parse($booking->check_out)->format('m/d H:i') }}</span>
                        </div>

                        {{-- Dynamic badges (only total guests now) --}}
                        <div class="booking-badges">
                            <span class="booking-badge">Prepaid</span>
                            <span class="booking-badge">{{ $booking->members }} Guests</span>
                        </div>

                        <div class="booking-hr"></div>

                        {{-- Details --}}
                        <dl class="booking-details">
                            <dt>Booking Date</dt>
                            <dd>{{ \Carbon\Carbon::parse($booking->booking_date)->format('Y-m-d H:i') }}</dd>
                            <dt>Amount</dt>
                            <dd>₹{{ number_format($booking->amount, 2) }}</dd>
                        </dl>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info text-center">No bookings found</div>
                </div>
            @endforelse
        </div>
    </div>

    {{-- Pagination --}}
    <div class="d-flex justify-content-center">
        {{ $bookings->links() }}
    </div>
</div>
@endsection 