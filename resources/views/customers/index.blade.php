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

    <!-- Customer Table -->
    <div class="table-container">
        <table class="table table-bordered table-hover table-sm">
            <thead class="table-light">
                <tr>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Email</th>
                    <th>Bookings</th>   {{-- Added --}}
                    <th>Date Added</th>
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

                        {{-- Show bookings count, clickable link --}}
                        <td>
                            <a href="{{ route('bookings.index', ['customer_id' => $customer->id]) }}" class="btn btn-link p-0">
                                {{ $customer->bookings_count ?? 0 }}
                            </a>
                        </td>

                        <td>{{ $customer->created_at->format('Y-m-d') }}</td>
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
                        <td colspan="7" class="text-center">No customers found</td> {{-- updated colspan from 6 → 7 --}}
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-2">
        {{ $customers->links() }}
    </div>
</div>

<!-- Modal (Add Customer Form) -->
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
