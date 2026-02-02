@extends('layouts.app')

@section('title', 'Patient Dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Welcome, {{ auth()->user()->name }}!</h1>
        <p class="text-gray-600">Manage your appointments and health records</p>
    </div>

    <!-- Quick Actions -->
    <div class="grid md:grid-cols-3 gap-6 mb-8">
        <a href="{{ route('patient.doctors') }}" class="bg-blue-600 text-white p-6 rounded-lg shadow-md hover:bg-blue-700 transition">
            <i class="fas fa-user-doctor text-3xl mb-2"></i>
            <h3 class="text-xl font-semibold">Find Doctors</h3>
            <p class="text-sm">Browse and book appointments</p>
        </a>

        <a href="{{ route('patient.appointments') }}" class="bg-green-600 text-white p-6 rounded-lg shadow-md hover:bg-green-700 transition">
            <i class="fas fa-calendar-check text-3xl mb-2"></i>
            <h3 class="text-xl font-semibold">My Appointments</h3>
            <p class="text-sm">View all your appointments</p>
        </a>

        <a href="{{ route('patient.profile') }}" class="bg-purple-600 text-white p-6 rounded-lg shadow-md hover:bg-purple-700 transition">
            <i class="fas fa-user text-3xl mb-2"></i>
            <h3 class="text-xl font-semibold">My Profile</h3>
            <p class="text-sm">Update your information</p>
        </a>
    </div>

    <!-- Upcoming Appointments -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">
            <i class="fas fa-calendar-alt text-blue-600 mr-2"></i>
            Upcoming Appointments
        </h2>

        @if($upcomingAppointments->count() > 0)
            <div class="space-y-4">
                @foreach($upcomingAppointments as $appointment)
                    <div class="border border-gray-200 rounded-lg p-4 hover:border-blue-300 transition">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <div class="flex items-center mb-2">
                                    <i class="fas fa-user-doctor text-blue-600 mr-2"></i>
                                    <h3 class="font-semibold text-lg">Dr. {{ $appointment->doctor->user->name }}</h3>
                                    <span class="ml-3 px-3 py-1 text-xs font-semibold rounded-full
                                        @if($appointment->status === 'pending') bg-yellow-100 text-yellow-800
                                        @elseif($appointment->status === 'confirmed') bg-blue-100 text-blue-800
                                        @endif">
                                        {{ ucfirst($appointment->status) }}
                                    </span>
                                </div>
                                <p class="text-sm text-gray-600 mb-1">
                                    <i class="fas fa-stethoscope mr-2"></i>{{ $appointment->doctor->specialization }}
                                </p>
                                <p class="text-sm text-gray-600 mb-1">
                                    <i class="fas fa-calendar mr-2"></i>{{ $appointment->appointment_date->format('l, F j, Y') }}
                                </p>
                                <p class="text-sm text-gray-600">
                                    <i class="fas fa-clock mr-2"></i>{{ date('h:i A', strtotime($appointment->appointment_time)) }}
                                </p>
                            </div>
                            <div class="flex gap-2">
                                <a href="{{ route('patient.appointments.show', $appointment->id) }}" 
                                   class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm">
                                    <i class="fas fa-eye mr-1"></i> View
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-8">
                <i class="fas fa-calendar-times text-gray-400 text-5xl mb-4"></i>
                <p class="text-gray-600 mb-4">No upcoming appointments</p>
                <a href="{{ route('patient.doctors') }}" class="inline-block bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                    Book Appointment
                </a>
            </div>
        @endif
    </div>

    <!-- Recent Appointments History -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">
            <i class="fas fa-history text-blue-600 mr-2"></i>
            Recent History
        </h2>

        @if($recentAppointments->count() > 0)
            <div class="space-y-3">
                @foreach($recentAppointments as $appointment)
                    <div class="border-l-4 pl-4 py-2
                        @if($appointment->status === 'completed') border-green-500
                        @elseif($appointment->status === 'cancelled') border-red-500
                        @endif">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="font-semibold">Dr. {{ $appointment->doctor->user->name }}</p>
                                <p class="text-sm text-gray-600">{{ $appointment->appointment_date->format('M j, Y') }} at {{ date('h:i A', strtotime($appointment->appointment_time)) }}</p>
                                <p class="text-xs text-gray-500 mt-1">
                                    <span class="px-2 py-1 rounded-full
                                        @if($appointment->status === 'completed') bg-green-100 text-green-800
                                        @elseif($appointment->status === 'cancelled') bg-red-100 text-red-800
                                        @endif">
                                        {{ ucfirst($appointment->status) }}
                                    </span>
                                </p>
                            </div>
                            <a href="{{ route('patient.appointments.show', $appointment->id) }}" 
                               class="text-blue-600 hover:text-blue-700 text-sm">
                                View Details <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-4 text-center">
                <a href="{{ route('patient.appointments') }}" class="text-blue-600 hover:text-blue-700 font-semibold">
                    View All Appointments <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
        @else
            <p class="text-gray-600 text-center py-4">No appointment history yet</p>
        @endif
    </div>
</div>
@endsection
