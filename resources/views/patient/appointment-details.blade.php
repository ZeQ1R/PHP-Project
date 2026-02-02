@extends('layouts.app')

@section('title', 'Appointment Details')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-6">
        <a href="{{ route('patient.appointments') }}" class="text-blue-600 hover:text-blue-700">
            <i class="fas fa-arrow-left mr-1"></i> Back to Appointments
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <!-- Header -->
        <div class="bg-blue-50 px-6 py-4 border-b flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Appointment Details</h2>
                <p class="text-gray-600">ID: #{{ $appointment->id }}</p>
            </div>
            <span class="px-4 py-2 text-sm font-semibold rounded-full
                @if($appointment->status === 'pending') bg-yellow-100 text-yellow-800
                @elseif($appointment->status === 'confirmed') bg-blue-100 text-blue-800
                @elseif($appointment->status === 'completed') bg-green-100 text-green-800
                @elseif($appointment->status === 'cancelled') bg-red-100 text-red-800
                @elseif($appointment->status === 'rejected') bg-gray-100 text-gray-800
                @endif">
                {{ ucfirst($appointment->status) }}
            </span>
        </div>

        <div class="p-6">
            <!-- Doctor Information -->
            <div class="mb-6 pb-6 border-b">
                <h3 class="text-lg font-semibold mb-3">Doctor Information</h3>
                <div class="flex items-center">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-user-doctor text-blue-600 text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="font-semibold text-lg">Dr. {{ $appointment->doctor->user->name }}</p>
                        <p class="text-gray-600">{{ $appointment->doctor->specialization }}</p>
                        <p class="text-sm text-gray-500">License: {{ $appointment->doctor->license_number }}</p>
                    </div>
                </div>
            </div>

            <!-- Appointment Details -->
            <div class="mb-6 pb-6 border-b">
                <h3 class="text-lg font-semibold mb-3">Appointment Details</h3>
                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Date</p>
                        <p class="font-semibold">{{ $appointment->appointment_date->format('l, F j, Y') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Time</p>
                        <p class="font-semibold">{{ date('h:i A', strtotime($appointment->appointment_time)) }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Duration</p>
                        <p class="font-semibold">{{ $appointment->duration }} minutes</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Consultation Fee</p>
                        <p class="font-semibold">${{ number_format($appointment->doctor->consultation_fee, 2) }}</p>
                    </div>
                </div>
            </div>

            <!-- Symptoms & Notes -->
            <div class="mb-6 pb-6 border-b">
                <h3 class="text-lg font-semibold mb-3">Symptoms & Notes</h3>
                <div class="space-y-3">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Symptoms</p>
                        <p class="text-gray-800">{{ $appointment->symptoms }}</p>
                    </div>
                    @if($appointment->notes)
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Additional Notes</p>
                            <p class="text-gray-800">{{ $appointment->notes }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Diagnosis & Prescription (if completed) -->
            @if($appointment->status === 'completed')
                <div class="mb-6 pb-6 border-b">
                    <h3 class="text-lg font-semibold mb-3">Medical Report</h3>
                    <div class="space-y-3">
                        @if($appointment->diagnosis)
                            <div>
                                <p class="text-sm text-gray-600 mb-1">Diagnosis</p>
                                <p class="text-gray-800">{{ $appointment->diagnosis }}</p>
                            </div>
                        @endif
                        @if($appointment->prescription)
                            <div>
                                <p class="text-sm text-gray-600 mb-1">Prescription</p>
                                <p class="text-gray-800">{{ $appointment->prescription }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Cancellation Reason (if cancelled/rejected) -->
            @if(in_array($appointment->status, ['cancelled', 'rejected']) && $appointment->cancellation_reason)
                <div class="mb-6 pb-6 border-b">
                    <h3 class="text-lg font-semibold mb-3 text-red-600">Cancellation Reason</h3>
                    <p class="text-gray-800">{{ $appointment->cancellation_reason }}</p>
                </div>
            @endif

            <!-- Actions -->
            <div class="flex gap-3">
                @if($appointment->isEditable())
                    <a href="{{ route('patient.appointments.edit', $appointment->id) }}" 
                       class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        <i class="fas fa-edit mr-2"></i> Edit Appointment
                    </a>
                @endif

                @if($appointment->isCancellable())
                    <button onclick="document.getElementById('cancelModal').classList.remove('hidden')"
                            class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                        <i class="fas fa-times mr-2"></i> Cancel Appointment
                    </button>
                @endif

                <a href="{{ route('patient.appointments') }}" 
                   class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                    <i class="fas fa-arrow-left mr-2"></i> Back to List
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Cancel Modal -->
@if($appointment->isCancellable())
    <div id="cancelModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Cancel Appointment</h3>
                <form method="POST" action="{{ route('patient.appointments.cancel', $appointment->id) }}">
                    @csrf
                    <div class="mb-4">
                        <label for="cancellation_reason" class="block text-gray-700 font-semibold mb-2">
                            Reason for Cancellation *
                        </label>
                        <textarea id="cancellation_reason" 
                                  name="cancellation_reason" 
                                  rows="3"
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                  required></textarea>
                    </div>
                    <div class="flex gap-3">
                        <button type="submit" class="flex-1 bg-red-600 text-white py-2 rounded-lg hover:bg-red-700">
                            Confirm Cancel
                        </button>
                        <button type="button" 
                                onclick="document.getElementById('cancelModal').classList.add('hidden')"
                                class="flex-1 bg-gray-200 text-gray-700 py-2 rounded-lg hover:bg-gray-300">
                            Close
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif
@endsection
