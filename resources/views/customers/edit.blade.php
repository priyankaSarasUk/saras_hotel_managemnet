@extends('layout.app')

@section('content')
<div class="container">
    <h2>Edit Customer</h2>

    <form action="{{ route('customers.update', $customer->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name">Name</label>
            <input type="text" name="name" value="{{ old('name', $customer->name) }}" class="form-control">
        </div>

        <div class="mb-3">
            <label for="phone">Phone</label>
            <input type="text" name="phone" value="{{ old('phone', $customer->phone) }}" class="form-control">
        </div>

        <div class="mb-3">
            <label for="email">Email</label>
            <input type="email" name="email" value="{{ old('email', $customer->email) }}" class="form-control">
        </div>

        <div class="mb-3">
            <label for="address">Address</label>
            <textarea name="address" class="form-control">{{ old('address', $customer->address) }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('customers.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
