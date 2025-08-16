<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f3f4f6; 
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 1rem; 
            box-sizing: border-box;
        }
    </style>
</head>
<body>
    <div class="bg-white p-8 rounded-lg shadow-xl w-full max-w-md mx-auto sm:mx-4">
        <h2 class="text-3xl font-bold text-center text-gray-800 mb-8">Login to Your Account</h2>

        
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        
        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
                
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        
        <form method="POST" action="{{ route('login') }}">

            @csrf

            <div class="mb-6">
                <label for="email" class="block text-gray-700 text-sm font-semibold mb-2">Email Address</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200"
                    placeholder="you@example.com"
                    
                    value="{{ old('email') }}"
                    required
                    autocomplete="email"
                    autofocus
                >
                
                @error('email')
                    
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="password" class="block text-gray-700 text-sm font-semibold mb-2">Password</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200"
                    placeholder="••••••••"
                    required
                    autocomplete="current-password"
                >
                
                @error('password')
                    
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center">
                    <input
                        type="checkbox"
                        name="remember"
                        id="remember"
                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                        
                        {{ old('remember') ? 'checked' : '' }}
                    >
                    <label for="remember" class="ml-2 block text-sm text-gray-900">Remember me</label>
                </div>
                
                <a href="#" class="text-sm text-indigo-600 hover:text-indigo-500 font-medium">
                    Forgot your password?
                </a>
            </div>

            <div>
                <button
                    type="submit"
                    class="w-full bg-indigo-600 text-white py-3 px-4 rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition duration-200 text-lg font-semibold shadow-md"
                >
                    Login
                </button>
            </div>
        </form>

        <p class="mt-8 text-center text-gray-600 text-sm">
            Don't have an account?
            
             <a href="{{ route('register') }}" class="text-indigo-600 hover:text-indigo-500 font-medium"> 
                Register here
            </a>
        </p>
    </div>
</body>
</html>
