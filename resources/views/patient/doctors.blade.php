@extends('layouts.app')

@section('title', 'Find Doctors')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Available Doctors</h1>
        <p class="text-gray-600">Choose a doctor and book your appointment</p>
    </div>

    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($doctors as $doctor)
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                <div class="p-6">
                    <div class="flex items-center mb-4">
                        <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-user-doctor text-blue-600 text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-xl font-semibold text-gray-900">Dr. {{ $doctor->user->name }}</h3>
                            <p class="text-sm text-gray-600">{{ $doctor->specialization }}</p>
                        </div>
                    </div>

                    <div class="space-y-2 mb-4">
                        <p class="text-sm text-gray-600">
                            <i class="fas fa-graduation-cap text-blue-600 mr-2"></i>
                            {{ $doctor->years_of_experience }} years experience
                        </p>
                        <p class="text-sm text-gray-600">
                            <i class="fas fa-certificate text-blue-600 mr-2"></i>
                            License: {{ $doctor->license_number }}
                        </p>
                        <p class="text-sm text-gray-600">
                            <i class="fas fa-dollar-sign text-blue-600 mr-2"></i>
                            Fee: ${{ number_format($doctor->consultation_fee, 2) }}
                        </p>
                    </div>

                    @if($doctor->bio)
                        <p class="text-sm text-gray-600 mb-4">{{ Str::limit($doctor->bio, 100) }}</p>
                    @endif

                    @if($doctor->qualifications)
                        <p class="text-xs text-gray-500 mb-4">
                            <i class="fas fa-award text-blue-600 mr-1"></i>
                            {{ Str::limit($doctor->qualifications, 80) }}
                        </p>
                    @endif

                    <a href="{{ route('patient.book-appointment', $doctor->id) }}" 
                       class="block w-full text-center bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 font-semibold">
                        <i class="fas fa-calendar-plus mr-2"></i> Book Appointment
                    </a>
                </div>
            </div>
        @endforeach
    </div>

    @if($doctors->count() === 0)
        <div class="text-center py-12">
            <i class="fas fa-user-doctor text-gray-400 text-6xl mb-4"></i>
            <p class="text-gray-600 text-lg">No doctors available at the moment</p>
        </div>
    @endif
</div>
@endsection
