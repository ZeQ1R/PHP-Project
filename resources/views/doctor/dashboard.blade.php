@extends('layouts.app')

@section('title', 'Doctor Dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Welcome, Dr. {{ auth()->user()->name }}!</h1>
        <p class="text-gray-600">Manage your appointments and schedule</p>
    </div>

    <!-- Statistics Cards -->
    <div class="grid md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm mb-1">Today's Appointments</p>
                    <p class="text-3xl font-bold text-blue-600">{{ $stats['total_today'] }}</p>
                </div>
                <i class="fas fa-calendar-day text-blue-600 text-3xl"></i>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm mb-1">Pending Requests</p>
                    <p class="text-3xl font-bold text-yellow-600">{{ $stats['pending'] }}</p>
                </div>
                <i class="fas fa-clock text-yellow-600 text-3xl"></i>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm mb-1">Confirmed</p>
                    <p class="text-3xl font-bold text-green-600">{{ $stats['confirmed'] }}</p>
                </div>
                <i class="fas fa-check-circle text-green-600 text-3xl"></i>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm mb-1">This Month</p>
                    <p class="text-3xl font-bold text-purple-600">{{ $stats['completed_this_month'] }}</p>
                </div>
                <i class="fas fa-chart-line text-purple-600 text-3xl"></i>
            </div>
        </div>
    </div>

    <!-- Pending Appointment Requests -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">
            <i class="fas fa-hourglass-half text-yellow-600 mr-2"></i>
            Pending Appointment Requests
        </h2>

        @if($pendingAppointments->count() > 0)
            <div class="space-y-4">
                @foreach($pendingAppointments as $appointment)
                    <div class="border border-gray-200 rounded-lg p-4 hover:border-blue-300 transition">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <div class="flex items-center mb-2">
                                    <i class="fas fa-user text-blue-600 mr-2"></i>
                                    <h3 class="font-semibold text-lg">{{ $appointment->patient->user->name }}</h3>
                                </div>
                                <div class="grid md:grid-cols-2 gap-2 text-sm text-gray-600">
                                    <p><i class="fas fa-calendar mr-2"></i>{{ $appointment->appointment_date->format('l, F j, Y') }}</p>
                                    <p><i class="fas fa-clock mr-2"></i>{{ date('h:i A', strtotime($appointment->appointment_time)) }}</p>
                                    <p><i class="fas fa-phone mr-2"></i>{{ $appointment->patient->user->phone }}</p>
                                    <p><i class="fas fa-envelope mr-2"></i>{{ $appointment->patient->user->email }}</p>
                                </div>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-600 font-semibold">Symptoms:</p>
                                    <p class="text-sm text-gray-800">{{ $appointment->symptoms }}</p>
                                </div>
                            </div>
                            <div class="flex flex-col gap-2 ml-4">
                                <form method="POST" action="{{ route('doctor.appointments.accept', $appointment->id) }}">
                                    @csrf
                                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 text-sm whitespace-nowrap">
                                        <i class="fas fa-check mr-1"></i> Accept
                                    </button>
                                </form>
                                <button onclick="showRejectModal({{ $appointment->id }})"
                                        class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 text-sm whitespace-nowrap">
                                    <i class="fas fa-times mr-1"></i> Reject
                                </button>
                                <a href="{{ route('doctor.appointments.show', $appointment->id) }}"
                                   class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm text-center whitespace-nowrap">
                                    <i class="fas fa-eye mr-1"></i> View
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-8">
                <i class="fas fa-check-circle text-green-400 text-5xl mb-4"></i>
                <p class="text-gray-600">No pending requests at the moment</p>
            </div>
        @endif
    </div>

    <!-- Upcoming Confirmed Appointments -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">
            <i class="fas fa-calendar-check text-blue-600 mr-2"></i>
            Upcoming Appointments
        </h2>

        @if($upcomingAppointments->count() > 0)
            <div class="space-y-3">
                @foreach($upcomingAppointments as $appointment)
                    <div class="border-l-4 border-blue-500 pl-4 py-2">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="font-semibold">{{ $appointment->patient->user->name }}</p>
                                <p class="text-sm text-gray-600">{{ $appointment->appointment_date->format('M j, Y') }} at {{ date('h:i A', strtotime($appointment->appointment_time)) }}</p>
                                <p class="text-xs text-gray-500 mt-1">{{ Str::limit($appointment->symptoms, 60) }}</p>
                            </div>
                            <a href="{{ route('doctor.appointments.show', $appointment->id) }}"
                               class="text-blue-600 hover:text-blue-700 text-sm">
                                View Details <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-4 text-center">
                <a href="{{ route('doctor.appointments') }}" class="text-blue-600 hover:text-blue-700 font-semibold">
                    View All Appointments <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
        @else
            <p class="text-gray-600 text-center py-4">No upcoming appointments</p>
        @endif
    </div>
</div>

<!-- Reject Modal -->
<div id="rejectModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Reject Appointment</h3>
            <form id="rejectForm" method="POST" action="">
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
                            onclick="document.getElementById('rejectModal').classList.add('hidden')"
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
function showRejectModal(appointmentId) {
    const form = document.getElementById('rejectForm');
    form.action = `/doctor/appointments/${appointmentId}/reject`;
    document.getElementById('rejectModal').classList.remove('hidden');
}
</script>
@endpush
@endsection
