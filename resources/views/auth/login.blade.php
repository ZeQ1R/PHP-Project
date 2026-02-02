@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="max-w-md mx-auto">
    <div class="bg-white rounded-lg shadow-md p-8">
        <div class="text-center mb-8">
            <i class="fas fa-tooth text-blue-600 text-4xl mb-2"></i>
            <h2 class="text-2xl font-bold text-gray-800">Login to Your Account</h2>
        </div>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-4">
                <label for="email" class="block text-gray-700 font-semibold mb-2">Email Address</label>
                <input type="email" 
                       id="email" 
                       name="email" 
                       value="{{ old('email') }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('email') border-red-500 @enderror"
                       required 
                       autofocus>
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password" class="block text-gray-700 font-semibold mb-2">Password</label>
                <input type="password" 
                       id="password" 
                       name="password"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('password') border-red-500 @enderror"
                       required>
                @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="flex items-center">
                    <input type="checkbox" name="remember" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    <span class="ml-2 text-sm text-gray-600">Remember me</span>
                </label>
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 font-semibold">
                <i class="fas fa-sign-in-alt mr-2"></i> Login
            </button>
        </form>

        <div class="mt-6 text-center">
            <p class="text-gray-600">Don't have an account? 
                <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-700 font-semibold">Register here</a>
            </p>
        </div>

        <div class="mt-4 p-4 bg-blue-50 rounded-lg">
            <p class="text-sm text-gray-600 font-semibold mb-2">Demo Accounts:</p>
            <p class="text-xs text-gray-600">Patient: patient@dental.com / password</p>
            <p class="text-xs text-gray-600">Doctor: doctor@dental.com / password</p>
        </div>
    </div>
</div>
@endsection
