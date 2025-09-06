@extends('layout.app')

@section('content')
<div class="container mt-4">

    <h2 class="mb-4">Customer List</h2>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Error Messages --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Search / Filter Form -->
    <form method="GET" action="{{ route('customers.index') }}" class="row g-2 align-items-center mb-3">
        <div class="col-md-3">
            <input type="text" name="name" class="form-control" placeholder="Search by name" value="{{ request('name') }}">
        </div>
        <div class="col-md-3">
            <input type="text" name="phone" class="form-control" placeholder="Search by phone" value="{{ request('phone') }}">
        </div>
        <div class="col-md-3">
            <input type="date" name="date" class="form-control" value="{{ request('date') }}">
        </div>
        <div class="col-md-3 d-flex gap-2">
            <button type="submit" class="btn btn-primary">Search</button>
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#customerModal">
                 Add Customer
            </button>
        </div>
    </form>

    {{-- ================= Desktop View (Table) ================= --}}
    <div class="d-none d-md-block table-container">
        <table class="table table-bordered table-hover table-sm">
            <thead class="table-light">
                <tr>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Email</th>
                    <th>Bookings</th>
                    <th>Date Added</th>
                    <th>Age</th>
                    <th>Nationality</th>
                    <th>Occupation</th>
                    <th style="width:120px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($customers as $customer)
                    <tr>
                        <td>{{ $customer->name }}</td>
                        <td>{{ $customer->phone }}</td>
                        <td>{{ $customer->address }}</td>
                        <td>{{ $customer->email }}</td>
                        <td>
                            <a href="{{ route('bookings.index', ['customer_id' => $customer->id]) }}" class="btn btn-link p-0">
                                {{ $customer->bookings_count ?? 0 }}
                            </a>
                        </td>
                        <td>{{ $customer->created_at->format('Y-m-d') }}</td>
                        <td>{{ $customer->age }}</td>
                        <td>{{ $customer->nationality }}</td>
                        <td>{{ $customer->occupation }}</td>
                        <td>
                            <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"
                                    onclick="return confirm('Are you sure you want to delete this customer?');">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="text-center">No customers found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- ================= Mobile View (Cards) ================= --}}
    <div class="d-block d-md-none">
        <style>
            .customer-card {
                background: #fff;
                border: 1px solid #e5e7eb;
                border-radius: 14px;
                box-shadow: 0 1px 6px rgba(17,24,39,.08);
                padding: 12px;
                margin-bottom: 12px;
            }
            .customer-head {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 6px;
            }
            .customer-name {
                font-weight: 700;
                font-size: 16px;
                color: #111827;
            }
            .customer-sub {
                font-size: 13px;
                color: #6b7280;
                margin-bottom: 4px;
            }
            .customer-sub a {
                color: #0d6efd;
                font-weight: 600;
                text-decoration: none;
            }
            .customer-sub a:hover {
                text-decoration: underline;
            }
            .dropdown-toggle::after {
                display: none;
            }
        </style>

        <div class="row">
            @forelse($customers as $customer)
                <div class="col-12">
                    <div class="customer-card">
                        <div class="customer-head">
                            <div class="customer-name">{{ $customer->name }}</div>

                            {{-- Three-dot menu --}}
                            <div class="dropdown">
                                <button class="btn btn-sm btn-light dropdown-toggle" type="button" id="dropdownMenuButton{{ $customer->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                    &#x22EE;
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton{{ $customer->id }}">
                                    <li><a class="dropdown-item" href="{{ route('customers.edit', $customer->id) }}">Edit</a></li>
                                    <li>
                                        <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this customer?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="dropdown-item text-danger" type="submit">Delete</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="customer-sub"><strong>Phone:</strong> {{ $customer->phone }}</div>
                        <div class="customer-sub"><strong>Email:</strong> {{ $customer->email }}</div>
                        <div class="customer-sub">
                            <strong>Bookings:</strong>
                            <a href="{{ route('bookings.index', ['customer_id' => $customer->id]) }}">
                                {{ $customer->bookings_count ?? 0 }}
                            </a>
                        </div>
                        <div class="customer-sub"><strong>Added:</strong> {{ $customer->created_at->format('Y-m-d') }}</div>
                        <div class="customer-sub"><strong>Age:</strong> {{ $customer->age }}</div>
                        <div class="customer-sub"><strong>Nationality:</strong> {{ $customer->nationality }}</div>
                        <div class="customer-sub"><strong>Occupation:</strong> {{ $customer->occupation }}</div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info text-center">No customers found</div>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-2 d-flex justify-content-center">
        {{ $customers->links() }}
    </div>
</div>

{{-- Modal (Add Customer Form) --}}
<div class="modal fade" id="customerModal" tabindex="-1" aria-labelledby="customerModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="customerModalLabel">Add Customer</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('customers.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Customer Name*</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phone*</label>
                        <input type="tel" name="phone" class="form-control" pattern="[0-9]{10}" placeholder="10-digit number" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Address</label>
                        <textarea name="address" class="form-control" rows="2"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Age</label>
                        <input type="number" name="age" class="form-control" min="1" max="120">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nationality</label>
                        <input type="text" name="nationality" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Occupation</label>
                        <input type="text" name="occupation" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-success w-100">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.table-container {
    max-height: 350px; 
    overflow-y: auto;  
    margin-top: 10px;
}

/* Compact table */
.table-sm td, .table-sm th {
    padding: 6px 10px;
}

/* Search bar spacing */
form .form-control {
    border-radius: 8px;
}

/* Bookings column links */
.table a.btn-link {
    color: #0d6efd;
    font-weight: 600;
    text-decoration: none;
}
.table a.btn-link:hover {
    text-decoration: underline;
}
</style>
@endpush
