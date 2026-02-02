@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow-md p-8">
        <div class="text-center mb-8">
            <i class="fas fa-user-plus text-blue-600 text-4xl mb-2"></i>
            <h2 class="text-2xl font-bold text-gray-800">Create New Account</h2>
        </div>

        <form method="POST" action="{{ route('register') }}" x-data="{ role: 'patient' }">
            @csrf

            <!-- Role Selection -->
            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">Register as</label>
                <div class="grid grid-cols-2 gap-4">
                    <label class="flex items-center justify-center p-4 border-2 rounded-lg cursor-pointer transition"
                           :class="role === 'patient' ? 'border-blue-600 bg-blue-50' : 'border-gray-300'">
                        <input type="radio" name="role" value="patient" x-model="role" class="hidden" required>
                        <div class="text-center">
                            <i class="fas fa-user text-3xl mb-2" :class="role === 'patient' ? 'text-blue-600' : 'text-gray-400'"></i>
                            <p class="font-semibold" :class="role === 'patient' ? 'text-blue-600' : 'text-gray-700'">Patient</p>
                        </div>
                    </label>
                    
                    <label class="flex items-center justify-center p-4 border-2 rounded-lg cursor-pointer transition"
                           :class="role === 'doctor' ? 'border-blue-600 bg-blue-50' : 'border-gray-300'">
                        <input type="radio" name="role" value="doctor" x-model="role" class="hidden" required>
                        <div class="text-center">
                            <i class="fas fa-user-doctor text-3xl mb-2" :class="role === 'doctor' ? 'text-blue-600' : 'text-gray-400'"></i>
                            <p class="font-semibold" :class="role === 'doctor' ? 'text-blue-600' : 'text-gray-700'">Doctor</p>
                        </div>
                    </label>
                </div>
                @error('role')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Basic Information -->
            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label for="name" class="block text-gray-700 font-semibold mb-2">Full Name *</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('name') border-red-500 @enderror" required>
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-gray-700 font-semibold mb-2">Email *</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('email') border-red-500 @enderror" required>
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-gray-700 font-semibold mb-2">Password *</label>
                    <input type="password" id="password" name="password"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('password') border-red-500 @enderror" required>
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-gray-700 font-semibold mb-2">Confirm Password *</label>
                    <input type="password" id="password_confirmation" name="password_confirmation"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>

                <div>
                    <label for="phone" class="block text-gray-700 font-semibold mb-2">Phone *</label>
                    <input type="text" id="phone" name="phone" value="{{ old('phone') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('phone') border-red-500 @enderror" required>
                    @error('phone')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="date_of_birth" class="block text-gray-700 font-semibold mb-2">Date of Birth *</label>
                    <input type="date" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('date_of_birth') border-red-500 @enderror" required>
                    @error('date_of_birth')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label for="gender" class="block text-gray-700 font-semibold mb-2">Gender *</label>
                    <select id="gender" name="gender"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('gender') border-red-500 @enderror" required>
                        <option value="">Select Gender</option>
                        <option value="male" {{ old('gender') === 'male' ? 'selected' : '' }}>Male</option>
                        <option value="female" {{ old('gender') === 'female' ? 'selected' : '' }}>Female</option>
                        <option value="other" {{ old('gender') === 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                    @error('gender')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label for="address" class="block text-gray-700 font-semibold mb-2">Address</label>
                    <textarea id="address" name="address" rows="2"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('address') }}</textarea>
                </div>
            </div>

            <!-- Patient-specific fields -->
            <div x-show="role === 'patient'" class="mt-6 border-t pt-6">
                <h3 class="text-lg font-semibold mb-4">Patient Information</h3>
                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label for="blood_group" class="block text-gray-700 font-semibold mb-2">Blood Group</label>
                        <input type="text" id="blood_group" name="blood_group" value="{{ old('blood_group') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="allergies" class="block text-gray-700 font-semibold mb-2">Allergies</label>
                        <input type="text" id="allergies" name="allergies" value="{{ old('allergies') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="emergency_contact_name" class="block text-gray-700 font-semibold mb-2">Emergency Contact Name</label>
                        <input type="text" id="emergency_contact_name" name="emergency_contact_name" value="{{ old('emergency_contact_name') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="emergency_contact_phone" class="block text-gray-700 font-semibold mb-2">Emergency Contact Phone</label>
                        <input type="text" id="emergency_contact_phone" name="emergency_contact_phone" value="{{ old('emergency_contact_phone') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div class="md:col-span-2">
                        <label for="medical_history" class="block text-gray-700 font-semibold mb-2">Medical History</label>
                        <textarea id="medical_history" name="medical_history" rows="2"
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('medical_history') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Doctor-specific fields -->
            <div x-show="role === 'doctor'" class="mt-6 border-t pt-6">
                <h3 class="text-lg font-semibold mb-4">Doctor Information</h3>
                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label for="specialization" class="block text-gray-700 font-semibold mb-2">Specialization</label>
                        <input type="text" id="specialization" name="specialization" value="{{ old('specialization') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="license_number" class="block text-gray-700 font-semibold mb-2">License Number</label>
                        <input type="text" id="license_number" name="license_number" value="{{ old('license_number') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="years_of_experience" class="block text-gray-700 font-semibold mb-2">Years of Experience</label>
                        <input type="number" id="years_of_experience" name="years_of_experience" value="{{ old('years_of_experience') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="consultation_fee" class="block text-gray-700 font-semibold mb-2">Consultation Fee</label>
                        <input type="number" step="0.01" id="consultation_fee" name="consultation_fee" value="{{ old('consultation_fee') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div class="md:col-span-2">
                        <label for="qualifications" class="block text-gray-700 font-semibold mb-2">Qualifications</label>
                        <textarea id="qualifications" name="qualifications" rows="2"
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('qualifications') }}</textarea>
                    </div>

                    <div class="md:col-span-2">
                        <label for="bio" class="block text-gray-700 font-semibold mb-2">Bio</label>
                        <textarea id="bio" name="bio" rows="3"
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('bio') }}</textarea>
                    </div>
                </div>
            </div>

            <button type="submit" class="w-full mt-6 bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 font-semibold">
                <i class="fas fa-user-plus mr-2"></i> Register
            </button>
        </form>

        <div class="mt-6 text-center">
            <p class="text-gray-600">Already have an account? 
                <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-700 font-semibold">Login here</a>
            </p>
        </div>
    </div>
</div>
@endsection
