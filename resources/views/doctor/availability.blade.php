@extends('layouts.app')

@section('title', 'Manage Availability')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Manage Availability</h1>
        <p class="text-gray-600">Set your weekly schedule and available time slots</p>
    </div>

    <!-- Add New Availability -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h2 class="text-xl font-semibold mb-4">Add New Time Slot</h2>
        <form method="POST" action="{{ route('doctor.availability.store') }}">
            @csrf
            <div class="grid md:grid-cols-4 gap-4">
                <div>
                    <label for="day_of_week" class="block text-gray-700 font-semibold mb-2">Day</label>
                    <select id="day_of_week" name="day_of_week" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required>
                        <option value="">Select Day</option>
                        <option value="Monday">Monday</option>
                        <option value="Tuesday">Tuesday</option>
                        <option value="Wednesday">Wednesday</option>
                        <option value="Thursday">Thursday</option>
                        <option value="Friday">Friday</option>
                        <option value="Saturday">Saturday</option>
                        <option value="Sunday">Sunday</option>
                    </select>
                </div>

                <div>
                    <label for="start_time" class="block text-gray-700 font-semibold mb-2">Start Time</label>
                    <input type="time" id="start_time" name="start_time"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                           required>
                </div>

                <div>
                    <label for="end_time" class="block text-gray-700 font-semibold mb-2">End Time</label>
                    <input type="time" id="end_time" name="end_time"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                           required>
                </div>

                <div>
                    <label for="slot_duration" class="block text-gray-700 font-semibold mb-2">Slot Duration (min)</label>
                    <select id="slot_duration" name="slot_duration"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required>
                        <option value="15">15 minutes</option>
                        <option value="30" selected>30 minutes</option>
                        <option value="45">45 minutes</option>
                        <option value="60">60 minutes</option>
                    </select>
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                    <i class="fas fa-plus mr-2"></i> Add Time Slot
                </button>
            </div>
        </form>
    </div>

    <!-- Current Schedule -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-semibold mb-4">Current Weekly Schedule</h2>

        @foreach($weekDays as $day)
            <div class="mb-6 pb-6 border-b last:border-b-0">
                <h3 class="text-lg font-semibold text-gray-900 mb-3">
                    <i class="fas fa-calendar-day text-blue-600 mr-2"></i>{{ $day }}
                </h3>

                @if(isset($availabilities[$day]) && $availabilities[$day]->count() > 0)
                    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-3">
                        @foreach($availabilities[$day] as $slot)
                            <div class="border border-gray-200 rounded-lg p-4 bg-gray-50">
                                <div class="flex justify-between items-start mb-2">
                                    <div>
                                        <p class="font-semibold text-gray-900">
                                            <i class="fas fa-clock text-blue-600 mr-1"></i>
                                            {{ date('h:i A', strtotime($slot->start_time)) }} - {{ date('h:i A', strtotime($slot->end_time)) }}
                                        </p>
                                        <p class="text-sm text-gray-600">
                                            <i class="fas fa-hourglass-half mr-1"></i>
                                            {{ $slot->slot_duration }} min slots
                                        </p>
                                    </div>
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $slot->is_available ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $slot->is_available ? 'Active' : 'Inactive' }}
                                    </span>
                                </div>
                                <form method="POST" action="{{ route('doctor.availability.delete', $slot->id) }}" 
                                      onsubmit="return confirm('Are you sure you want to delete this time slot?');"
                                      class="mt-2">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-700 text-sm">
                                        <i class="fas fa-trash mr-1"></i> Remove
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-4 bg-gray-50 rounded-lg">
                        <i class="fas fa-info-circle text-gray-400 text-2xl mb-2"></i>
                        <p class="text-gray-600">No availability set for this day</p>
                    </div>
                @endif
            </div>
        @endforeach
    </div>

    <!-- Info Box -->
    <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
        <div class="flex">
            <i class="fas fa-info-circle text-blue-600 text-xl mr-3 mt-1"></i>
            <div>
                <h4 class="font-semibold text-blue-900 mb-1">Tips for Managing Availability</h4>
                <ul class="text-sm text-blue-800 space-y-1">
                    <li>• Set realistic time slots that allow adequate time for each patient</li>
                    <li>• Consider adding buffer time between appointments</li>
                    <li>• You can add multiple time slots for the same day (e.g., morning and afternoon sessions)</li>
                    <li>• Patients will only see available slots when booking appointments</li>
                    <li>• Remove time slots that you no longer want to offer</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
