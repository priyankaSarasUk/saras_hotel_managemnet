<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Registration</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Inter', sans-serif; 
            min-height: 100vh; 
            display: flex;
            align-items: center; 
            justify-content: center; 
            padding: 1rem; 
            box-sizing: border-box; 
        }
        .form-container {
            width: 100%; 
            max-width: 500px; 
        }
        .card {
            border: none; 
            border-radius: 1rem; 
            box-shadow: 0 0.75rem 1.5rem rgba(0,0,0,0.1); 
            overflow: hidden; 
        }
        .card-header {
            background-color: #0d6efd; 
            color: white;
            padding: 1.75rem; 
            border-bottom: none; 
            text-align: center;
            font-weight: 700; 
            font-size: 1.75rem; 
        }
        .card-body {
            padding: 2.5rem;
        }
        .btn-primary {
            background-color: #007bff; 
            border-color: #007bff; 
            font-weight: 600; 
            padding: 0.75rem 1.25rem; 
            font-size: 1.1rem; 
            border-radius: 0.5rem; 
            transition: background-color 0.2s ease-in-out, border-color 0.2s ease-in-out, transform 0.1s ease-in-out;
        }
        .btn-primary:hover {
            background-color: #0056b3; 
            border-color: #0056b3;
            transform: translateY(-2px);
        }
        .btn-primary:active {
            transform: translateY(0);
        }
        .form-label {
            font-weight: 600; 
            color: #343a40; 
            margin-bottom: 0.5rem;
        }
        .form-control {
            border-radius: 0.5rem; 
            padding: 0.75rem 1rem; 
            font-size: 1rem; 
            transition: border-color 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        }
        .form-control:focus {
            border-color: #80bdff;
            box-shadow: 0 0 0 0.25rem rgba(0, 123, 255, 0.25);
        }
        .alert {
            font-size: 0.95rem; 
            padding: 1rem 1.25rem; 
            margin-bottom: 2rem; 
            border-radius: 0.5rem; 
        }
        .text-danger {
            font-size: 0.875rem; 
            margin-top: 0.25rem; 
            display: block; 
        }
    </style>
</head>
<body>
<div class="container form-container">
    <div class="card">
        <div class="card-header">
            <h3 class="mb-0">Register Your Hotel</h3>
        </div>
        <div class="card-body">
            {{-- Validation Errors --}}
            @if($errors->any())
                <div class="alert alert-danger" role="alert">
                    <ul class="mb-0 ps-3"> 
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Success Message --}}
            @if(session('success'))
                <div class="alert alert-success" role="alert">{{ session('success') }}</div>
            @endif

            {{-- Form Start --}}
            <form method="POST" action="{{ route('register.store') }}">
                @csrf

                <div class="mb-4">
                    <label for="hotelName" class="form-label">Hotel Name*</label>
                    <input type="text" name="name" id="hotelName" class="form-control" value="{{ old('name') }}" required>
                    @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="mb-4">
                    <label for="hotelEmail" class="form-label">Email*</label>
                    <input type="email" name="email" id="hotelEmail" class="form-control" value="{{ old('email') }}" required>
                    @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="mb-4">
                    <label for="hotelPhone" class="form-label">Phone*</label>
                    <input type="tel" name="phone" id="hotelPhone" class="form-control" value="{{ old('phone') }}" required>
                    @error('phone') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="mb-4">
                    <label for="hotelAddress" class="form-label">Address</label>
                    <textarea name="address" id="hotelAddress" class="form-control" rows="3">{{ old('address') }}</textarea>
                    @error('address') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="mb-4">
                    <label for="hotelPassword" class="form-label">Password*</label>
                    <input type="password" name="password" id="hotelPassword" class="form-control" required>
                    @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="mb-5">
                    <label for="passwordConfirm" class="form-label">Confirm Password*</label>
                    <input type="password" name="password_confirmation" id="passwordConfirm" class="form-control" required>
                    @error('password_confirmation') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <button type="submit" class="btn btn-primary w-100">Register Hotel</button>
            </form>

            <!-- Login redirect link -->
            <p class="mt-3 text-center">
                Already have an account? <a href="{{ route('login') }}">Login here</a>
            </p>
            {{-- Form End --}}
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
