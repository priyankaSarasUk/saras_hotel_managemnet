@extends('layout.app')

@section('content')
<div class="container mt-4">
    <h2>Edit Customer</h2>

    <form action="{{ route('customers.update', $customer->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name">Name*</label>
            <input type="text" name="name" value="{{ old('name', $customer->name) }}" class="form-control" required>
            @error('name')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="phone">Phone*</label>
            <input type="tel" name="phone" value="{{ old('phone', $customer->phone) }}" class="form-control" pattern="[0-9]{10}" placeholder="10-digit number" required>
            @error('phone')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="email">Email</label>
            <input type="email" name="email" value="{{ old('email', $customer->email) }}" class="form-control">
            @error('email')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="address">Address</label>
            <textarea name="address" class="form-control">{{ old('address', $customer->address) }}</textarea>
            @error('address')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="age">Age</label>
            <input type="number" name="age" value="{{ old('age', $customer->age) }}" class="form-control" min="1" max="120">
            @error('age')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="nationality">Nationality</label>
            <input type="text" name="nationality" value="{{ old('nationality', $customer->nationality) }}" class="form-control">
            @error('nationality')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="occupation">Occupation</label>
            <input type="text" name="occupation" value="{{ old('occupation', $customer->occupation) }}" class="form-control">
            @error('occupation')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('customers.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
