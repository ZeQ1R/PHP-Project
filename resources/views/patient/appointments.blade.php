@extends('layouts.app')

@section('title', 'My Appointments')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">My Appointments</h1>
            <p class="text-gray-600">View and manage all your appointments</p>
        </div>
        <a href="{{ route('patient.doctors') }}" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
            <i class="fas fa-plus mr-2"></i> New Appointment
        </a>
    </div>

    @if($appointments->count() > 0)
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Doctor</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date & Time</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Symptoms</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($appointments as $appointment)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                                <i class="fas fa-user-doctor text-blue-600"></i>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">Dr. {{ $appointment->doctor->user->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $appointment->doctor->specialization }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $appointment->appointment_date->format('M j, Y') }}</div>
                                    <div class="text-sm text-gray-500">{{ date('h:i A', strtotime($appointment->appointment_time)) }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                        @if($appointment->status === 'pending') bg-yellow-100 text-yellow-800
                                        @elseif($appointment->status === 'confirmed') bg-blue-100 text-blue-800
                                        @elseif($appointment->status === 'completed') bg-green-100 text-green-800
                                        @elseif($appointment->status === 'cancelled') bg-red-100 text-red-800
                                        @elseif($appointment->status === 'rejected') bg-gray-100 text-gray-800
                                        @endif">
                                        {{ ucfirst($appointment->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900">{{ Str::limit($appointment->symptoms, 50) }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex gap-2">
                                        <a href="{{ route('patient.appointments.show', $appointment->id) }}" 
                                           class="text-blue-600 hover:text-blue-900">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if($appointment->isEditable())
                                            <a href="{{ route('patient.appointments.edit', $appointment->id) }}" 
                                               class="text-green-600 hover:text-green-900">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="bg-white rounded-lg shadow-md p-12 text-center">
            <i class="fas fa-calendar-times text-gray-400 text-6xl mb-4"></i>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">No Appointments Yet</h3>
            <p class="text-gray-600 mb-6">Start by booking your first appointment with our doctors</p>
            <a href="{{ route('patient.doctors') }}" class="inline-block bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700">
                <i class="fas fa-calendar-plus mr-2"></i> Book Appointment
            </a>
        </div>
    @endif
</div>
@endsection
