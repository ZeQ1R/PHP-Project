@extends('layouts.app')

@section('title', 'Book Appointment')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-6">
        <a href="{{ route('patient.doctors') }}" class="text-blue-600 hover:text-blue-700">
            <i class="fas fa-arrow-left mr-1"></i> Back to Doctors
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <!-- Doctor Info -->
        <div class="bg-blue-50 p-6 border-b">
            <div class="flex items-center">
                <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-user-doctor text-blue-600 text-3xl"></i>
                </div>
                <div class="ml-4">
                    <h2 class="text-2xl font-bold text-gray-900">Dr. {{ $doctor->user->name }}</h2>
                    <p class="text-gray-600">{{ $doctor->specialization }}</p>
                    <p class="text-sm text-gray-600 mt-1">
                        <i class="fas fa-dollar-sign mr-1"></i> Consultation Fee: ${{ number_format($doctor->consultation_fee, 2) }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Booking Form -->
        <div class="p-6">
            <h3 class="text-xl font-semibold mb-4">Book Your Appointment</h3>

            <form method="POST" action="{{ route('patient.store-appointment') }}" x-data="{
                selectedDate: '',
                slots: [],
                selectedSlot: '',
                loading: false,
                async fetchSlots() {
                    if (!this.selectedDate) return;
                    this.loading = true;
                    this.slots = [];
                    this.selectedSlot = '';
                    
                    try {
                        const response = await fetch(`{{ route('patient.available-slots', $doctor->id) }}?date=${this.selectedDate}`);
                        this.slots = await response.json();
                    } catch (error) {
                        console.error('Error fetching slots:', error);
                    } finally {
                        this.loading = false;
                    }
                }
            }">
                @csrf
                <input type="hidden" name="doctor_id" value="{{ $doctor->id }}">

                <div class="mb-4">
                    <label for="appointment_date" class="block text-gray-700 font-semibold mb-2">
                        Select Date *
                    </label>
                    <input type="date" 
                           id="appointment_date" 
                           name="appointment_date"
                           x-model="selectedDate"
                           @change="fetchSlots()"
                           min="{{ date('Y-m-d') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                           required>
                    @error('appointment_date')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4" x-show="selectedDate">
                    <label class="block text-gray-700 font-semibold mb-2">
                        Available Time Slots *
                    </label>
                    
                    <div x-show="loading" class="text-center py-4">
                        <i class="fas fa-spinner fa-spin text-blue-600 text-2xl"></i>
                        <p class="text-gray-600 mt-2">Loading available slots...</p>
                    </div>

                    <div x-show="!loading && slots.length > 0" class="grid grid-cols-3 sm:grid-cols-4 gap-2">
                        <template x-for="slot in slots" :key="slot.time">
                            <label class="cursor-pointer">
                                <input type="radio" 
                                       name="appointment_time" 
                                       :value="slot.time"
                                       x-model="selectedSlot"
                                       class="hidden"
                                       required>
                                <div class="border-2 rounded-lg p-2 text-center transition"
                                     :class="selectedSlot === slot.time ? 'border-blue-600 bg-blue-50 text-blue-600' : 'border-gray-300 hover:border-blue-300'">
                                    <span class="text-sm font-semibold" x-text="slot.formatted"></span>
                                </div>
                            </label>
                        </template>
                    </div>

                    <div x-show="!loading && slots.length === 0 && selectedDate" class="text-center py-4 bg-yellow-50 rounded-lg">
                        <i class="fas fa-info-circle text-yellow-600 text-xl mb-2"></i>
                        <p class="text-gray-600">No available slots for this date. Please select another date.</p>
                    </div>

                    @error('appointment_time')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="symptoms" class="block text-gray-700 font-semibold mb-2">
                        Symptoms / Reason for Visit *
                    </label>
                    <textarea id="symptoms" 
                              name="symptoms" 
                              rows="3"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                              placeholder="Please describe your symptoms or reason for consultation"
                              required>{{ old('symptoms') }}</textarea>
                    @error('symptoms')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="notes" class="block text-gray-700 font-semibold mb-2">
                        Additional Notes (Optional)
                    </label>
                    <textarea id="notes" 
                              name="notes" 
                              rows="2"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                              placeholder="Any additional information you'd like to share">{{ old('notes') }}</textarea>
                </div>

                <div class="flex gap-3">
                    <button type="submit" 
                            class="flex-1 bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 font-semibold"
                            x-bind:disabled="!selectedSlot">
                        <i class="fas fa-calendar-check mr-2"></i> Book Appointment
                    </button>
                    <a href="{{ route('patient.doctors') }}" 
                       class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 font-semibold">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
