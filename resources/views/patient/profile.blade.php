@extends('layouts.app')

@section('title', 'My Profile')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">My Profile</h1>
        <p class="text-gray-600">Update your personal and medical information</p>
    </div>

    <form method="POST" action="{{ route('patient.profile.update') }}" class="bg-white rounded-lg shadow-md p-6 space-y-6">
        @csrf
        @method('PUT')

        <div>
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Basic Information</h2>
            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label for="name" class="block text-gray-700 font-semibold mb-2">Full Name</label>
                    <input type="text" id="name" name="name" required
                           value="{{ old('name', $user->name) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label for="email" class="block text-gray-700 font-semibold mb-2">Email</label>
                    <input type="email" id="email" name="email" disabled
                           value="{{ $user->email }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-100 text-gray-600">
                </div>
                <div>
                    <label for="phone" class="block text-gray-700 font-semibold mb-2">Phone</label>
                    <input type="text" id="phone" name="phone" required
                           value="{{ old('phone', $user->phone) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label for="date_of_birth" class="block text-gray-700 font-semibold mb-2">Date of Birth</label>
                    <input type="date" id="date_of_birth" name="date_of_birth" required
                           value="{{ old('date_of_birth', optional($user->date_of_birth)->format('Y-m-d')) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label for="gender" class="block text-gray-700 font-semibold mb-2">Gender</label>
                    <select id="gender" name="gender" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @php($selectedGender = old('gender', $user->gender))
                        <option value="male" @selected($selectedGender === 'male')>Male</option>
                        <option value="female" @selected($selectedGender === 'female')>Female</option>
                        <option value="other" @selected($selectedGender === 'other')>Other</option>
                    </select>
                </div>
                <div>
                    <label for="address" class="block text-gray-700 font-semibold mb-2">Address</label>
                    <input type="text" id="address" name="address"
                           value="{{ old('address', $user->address) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>
        </div>

        <div>
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Medical Information</h2>
            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label for="blood_group" class="block text-gray-700 font-semibold mb-2">Blood Group</label>
                    <input type="text" id="blood_group" name="blood_group"
                           value="{{ old('blood_group', optional($patient)->blood_group) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label for="allergies" class="block text-gray-700 font-semibold mb-2">Allergies</label>
                    <input type="text" id="allergies" name="allergies"
                           value="{{ old('allergies', optional($patient)->allergies) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="md:col-span-2">
                    <label for="medical_history" class="block text-gray-700 font-semibold mb-2">Medical History</label>
                    <textarea id="medical_history" name="medical_history" rows="3"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('medical_history', optional($patient)->medical_history) }}</textarea>
                </div>
            </div>
        </div>

        <div>
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Emergency Contact</h2>
            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label for="emergency_contact_name" class="block text-gray-700 font-semibold mb-2">Contact Name</label>
                    <input type="text" id="emergency_contact_name" name="emergency_contact_name"
                           value="{{ old('emergency_contact_name', optional($patient)->emergency_contact_name) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label for="emergency_contact_phone" class="block text-gray-700 font-semibold mb-2">Contact Phone</label>
                    <input type="text" id="emergency_contact_phone" name="emergency_contact_phone"
                           value="{{ old('emergency_contact_phone', optional($patient)->emergency_contact_phone) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>
        </div>

        <div class="pt-2">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                <i class="fas fa-save mr-2"></i> Save Changes
            </button>
        </div>
    </form>
</div>
@endsection
