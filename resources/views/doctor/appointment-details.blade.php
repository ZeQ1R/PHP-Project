@extends('layouts.app')

@section('title', 'Appointment Details')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-6">
        <a href="{{ route('doctor.appointments') }}" class="text-blue-600 hover:text-blue-700">
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
            <!-- Patient Information -->
            <div class="mb-6 pb-6 border-b">
                <h3 class="text-lg font-semibold mb-3">Patient Information</h3>
                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Name</p>
                        <p class="font-semibold">{{ $appointment->patient->user->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Phone</p>
                        <p class="font-semibold">{{ $appointment->patient->user->phone }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Email</p>
                        <p class="font-semibold">{{ $appointment->patient->user->email }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Blood Group</p>
                        <p class="font-semibold">{{ $appointment->patient->blood_group ?? 'N/A' }}</p>
                    </div>
                    @if($appointment->patient->allergies)
                        <div class="md:col-span-2">
                            <p class="text-sm text-gray-600 mb-1">Allergies</p>
                            <p class="font-semibold text-red-600">{{ $appointment->patient->allergies }}</p>
                        </div>
                    @endif
                    @if($appointment->patient->medical_history)
                        <div class="md:col-span-2">
                            <p class="text-sm text-gray-600 mb-1">Medical History</p>
                            <p class="text-gray-800">{{ $appointment->patient->medical_history }}</p>
                        </div>
                    @endif
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
                        <p class="text-sm text-gray-600 mb-1">Booked On</p>
                        <p class="font-semibold">{{ $appointment->created_at->format('M j, Y h:i A') }}</p>
                    </div>
                </div>
            </div>

            <!-- Symptoms -->
            <div class="mb-6 pb-6 border-b">
                <h3 class="text-lg font-semibold mb-3">Patient's Concern</h3>
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

            <!-- Diagnosis & Prescription -->
            @if($appointment->status === 'completed')
                <div class="mb-6 pb-6 border-b bg-green-50 -mx-6 px-6 py-4">
                    <h3 class="text-lg font-semibold mb-3 text-green-800">Medical Report</h3>
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
                        <p class="text-xs text-gray-500">Completed on: {{ $appointment->completed_at->format('M j, Y h:i A') }}</p>
                    </div>
                </div>
            @endif

            <!-- Actions for Pending Appointments -->
            @if($appointment->status === 'pending')
                <div class="mb-6 pb-6 border-b">
                    <h3 class="text-lg font-semibold mb-3">Actions</h3>
                    <div class="flex gap-3">
                        <form method="POST" action="{{ route('doctor.appointments.accept', $appointment->id) }}">
                            @csrf
                            <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                                <i class="fas fa-check mr-2"></i> Accept Appointment
                            </button>
                        </form>
                        <button onclick="showRejectModal()"
                                class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                            <i class="fas fa-times mr-2"></i> Reject Appointment
                        </button>
                    </div>
                </div>
            @endif

            <!-- Complete Appointment Form -->
            @if($appointment->status === 'confirmed')
                <div class="mb-6 pb-6 border-b">
                    <h3 class="text-lg font-semibold mb-3">Complete Appointment</h3>
                    <form method="POST" action="{{ route('doctor.appointments.complete', $appointment->id) }}">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <label for="diagnosis" class="block text-gray-700 font-semibold mb-2">
                                    Diagnosis *
                                </label>
                                <textarea id="diagnosis" name="diagnosis" rows="3"
                                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                          required>{{ $appointment->diagnosis }}</textarea>
                            </div>
                            <div>
                                <label for="prescription" class="block text-gray-700 font-semibold mb-2">
                                    Prescription
                                </label>
                                <textarea id="prescription" name="prescription" rows="3"
                                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">{{ $appointment->prescription }}</textarea>
                            </div>
                            <div>
                                <label for="notes" class="block text-gray-700 font-semibold mb-2">
                                    Additional Notes
                                </label>
                                <textarea id="notes" name="notes" rows="2"
                                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">{{ $appointment->notes }}</textarea>
                            </div>
                            <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                                <i class="fas fa-check-circle mr-2"></i> Mark as Completed
                            </button>
                        </div>
                    </form>
                </div>
            @endif

            <div class="flex gap-3">
                <a href="{{ route('doctor.appointments') }}" 
                   class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                    <i class="fas fa-arrow-left mr-2"></i> Back to List
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div id="rejectModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Reject Appointment</h3>
            <form method="POST" action="{{ route('doctor.appointments.reject', $appointment->id) }}">
                @csrf
                <div class="mb-4">
                    <label for="reject_reason" class="block text-gray-700 font-semibold mb-2">
                        Reason for Rejection *
                    </label>
                    <textarea id="reject_reason" 
                              name="cancellation_reason" 
                              rows="3"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                              required></textarea>
                </div>
                <div class="flex gap-3">
                    <button type="submit" class="flex-1 bg-red-600 text-white py-2 rounded-lg hover:bg-red-700">
                        Confirm Reject
                    </button>
                    <button type="button" 
                            onclick="hideRejectModal()"
                            class="flex-1 bg-gray-200 text-gray-700 py-2 rounded-lg hover:bg-gray-300">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
function showRejectModal() {
    document.getElementById('rejectModal').classList.remove('hidden');
}

function hideRejectModal() {
    document.getElementById('rejectModal').classList.add('hidden');
}
</script>
@endpush
@endsection
