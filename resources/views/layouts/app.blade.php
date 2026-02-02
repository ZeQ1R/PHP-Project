<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dental Appointment System')</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    @stack('styles')
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center">
                        <i class="fas fa-tooth text-blue-600 text-2xl mr-2"></i>
                        <span class="text-xl font-bold text-gray-800">Dental Care</span>
                    </a>
                </div>

                <div class="flex items-center space-x-4">
                    @auth
                        @if(auth()->user()->isPatient())
                            <a href="{{ route('patient.dashboard') }}" class="text-gray-700 hover:text-blue-600">
                                <i class="fas fa-home mr-1"></i> Dashboard
                            </a>
                            <a href="{{ route('patient.doctors') }}" class="text-gray-700 hover:text-blue-600">
                                <i class="fas fa-user-doctor mr-1"></i> Doctors
                            </a>
                            <a href="{{ route('patient.appointments') }}" class="text-gray-700 hover:text-blue-600">
                                <i class="fas fa-calendar-check mr-1"></i> Appointments
                            </a>
                        @elseif(auth()->user()->isDoctor())
                            <a href="{{ route('doctor.dashboard') }}" class="text-gray-700 hover:text-blue-600">
                                <i class="fas fa-home mr-1"></i> Dashboard
                            </a>
                            <a href="{{ route('doctor.appointments') }}" class="text-gray-700 hover:text-blue-600">
                                <i class="fas fa-calendar-check mr-1"></i> Appointments
                            </a>
                            <a href="{{ route('doctor.availability') }}" class="text-gray-700 hover:text-blue-600">
                                <i class="fas fa-clock mr-1"></i> Availability
                            </a>
                        @endif

                        <!-- User Dropdown -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center text-gray-700 hover:text-blue-600">
                                <i class="fas fa-user-circle text-2xl"></i>
                                <span class="ml-2">{{ auth()->user()->name }}</span>
                                <i class="fas fa-chevron-down ml-1 text-sm"></i>
                            </button>
                            
                            <div x-show="open" @click.away="open = false" 
                                 class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-10">
                                @if(auth()->user()->isPatient())
                                    <a href="{{ route('patient.profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-user mr-2"></i> Profile
                                    </a>
                                @elseif(auth()->user()->isDoctor())
                                    <a href="{{ route('doctor.profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-user mr-2"></i> Profile
                                    </a>
                                @endif
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-sign-out-alt mr-2"></i> Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600">
                            <i class="fas fa-sign-in-alt mr-1"></i> Login
                        </a>
                        <a href="{{ route('register') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                            <i class="fas fa-user-plus mr-1"></i> Register
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        </div>
    @endif

    <!-- Main Content -->
    <main class="py-8">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white shadow-lg mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="text-center text-gray-600">
                <p>&copy; {{ date('Y') }} Dental Appointment System. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Alpine.js for dropdowns -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    @stack('scripts')
</body>
</html>
