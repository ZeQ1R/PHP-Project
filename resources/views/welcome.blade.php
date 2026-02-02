@extends('layouts.app')

@section('title', 'Welcome - Dental Appointment System')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Hero Section -->
    <div class="text-center py-16">
        <i class="fas fa-tooth text-blue-600 text-6xl mb-4"></i>
        <h1 class="text-4xl font-bold text-gray-900 mb-4">
            Welcome to Dental Care Appointment System
        </h1>
        <p class="text-xl text-gray-600 mb-8">
            Book your dental appointments easily and manage your dental health
        </p>
        <div class="space-x-4">
            <a href="{{ route('register') }}" class="inline-block bg-blue-600 text-white px-8 py-3 rounded-lg text-lg font-semibold hover:bg-blue-700">
                Get Started
            </a>
            <a href="{{ route('login') }}" class="inline-block bg-gray-200 text-gray-800 px-8 py-3 rounded-lg text-lg font-semibold hover:bg-gray-300">
                Login
            </a>
        </div>
    </div>

    <!-- Features -->
    <div class="grid md:grid-cols-3 gap-8 mt-16">
        <div class="bg-white p-6 rounded-lg shadow-md text-center">
            <i class="fas fa-calendar-check text-blue-600 text-4xl mb-4"></i>
            <h3 class="text-xl font-semibold mb-2">Easy Booking</h3>
            <p class="text-gray-600">Book appointments with your preferred dentist in just a few clicks</p>
        </div>
        
        <div class="bg-white p-6 rounded-lg shadow-md text-center">
            <i class="fas fa-user-doctor text-blue-600 text-4xl mb-4"></i>
            <h3 class="text-xl font-semibold mb-2">Expert Dentists</h3>
            <p class="text-gray-600">Access to experienced and qualified dental professionals</p>
        </div>
        
        <div class="bg-white p-6 rounded-lg shadow-md text-center">
            <i class="fas fa-history text-blue-600 text-4xl mb-4"></i>
            <h3 class="text-xl font-semibold mb-2">Track History</h3>
            <p class="text-gray-600">Keep track of all your appointments and medical records</p>
        </div>
    </div>

    <!-- Call to Action -->
    <div class="bg-blue-50 rounded-lg p-8 mt-16 text-center">
        <h2 class="text-3xl font-bold text-gray-900 mb-4">Ready to take care of your dental health?</h2>
        <p class="text-lg text-gray-600 mb-6">Join us today and experience hassle-free dental care management</p>
        <a href="{{ route('register') }}" class="inline-block bg-blue-600 text-white px-8 py-3 rounded-lg text-lg font-semibold hover:bg-blue-700">
            Register Now
        </a>
    </div>
</div>
@endsection
