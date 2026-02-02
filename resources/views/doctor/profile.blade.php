@extends('layouts.app')

@section('title', 'My Profile')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">My Profile</h1>
        <p class="text-gray-600">Update your personal and professional information</p>
    </div>

    <form method="POST" action="{{ route('doctor.profile.update') }}" class="bg-white rounded-lg shadow-md p-6 space-y-6">
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
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Professional Information</h2>
            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label for="specialization" class="block text-gray-700 font-semibold mb-2">Specialization</label>
                    <input type="text" id="specialization" name="specialization" required
                           value="{{ old('specialization', optional($doctor)->specialization) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label for="license_number" class="block text-gray-700 font-semibold mb-2">License Number</label>
                    <input type="text" id="license_number" name="license_number" required
                           value="{{ old('license_number', optional($doctor)->license_number) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label for="years_of_experience" class="block text-gray-700 font-semibold mb-2">Years of Experience</label>
                    <input type="number" id="years_of_experience" name="years_of_experience" min="0" required
                           value="{{ old('years_of_experience', optional($doctor)->years_of_experience) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label for="consultation_fee" class="block text-gray-700 font-semibold mb-2">Consultation Fee</label>
                    <input type="number" step="0.01" min="0" id="consultation_fee" name="consultation_fee" required
                           value="{{ old('consultation_fee', optional($doctor)->consultation_fee) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="md:col-span-2">
                    <label for="qualifications" class="block text-gray-700 font-semibold mb-2">Qualifications</label>
                    <textarea id="qualifications" name="qualifications" rows="3"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('qualifications', optional($doctor)->qualifications) }}</textarea>
                </div>
                <div class="md:col-span-2">
                    <label for="bio" class="block text-gray-700 font-semibold mb-2">Bio</label>
                    <textarea id="bio" name="bio" rows="4"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('bio', optional($doctor)->bio) }}</textarea>
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
