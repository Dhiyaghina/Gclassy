<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }} - Dashboard</title>
    <link rel="icon" href="data:,">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50">
    <!-- Success Login Notification -->
    @if(session('success') || request()->get('login_success'))
    <div id="success-notification" class="fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 transition-all duration-300">
        <div class="flex items-center space-x-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span>Berhasil login!</span>
        </div>
    </div>
    @endif

    <!-- Navbar -->
    <nav class="bg-white shadow-lg border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo dan Brand -->
                <div class="flex items-center space-x-4">
                    <div class="flex-shrink-0">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo GCLASSY" class="h-10 w-auto">
                    </div>
                    <h1 class="text-xl font-bold text-gray-900">Dashboard</h1>
                </div>

                <!-- User Info & Actions -->
                <div class="flex items-center space-x-4">
                    <!-- Welcome Message -->
                    <div class="hidden md:flex items-center space-x-3">
                        <span class="text-sm text-gray-600">Welcome back!</span>
                        <div class="h-8 w-8 bg-gray-300 rounded-full flex items-center justify-center">
                            <span class="text-xs font-medium text-gray-700">{{ substr(Auth::user()->name ?? 'U', 0, 1) }}</span>
                        </div>
                    </div>

                    <!-- User Avatar -->
                    <div class="h-10 w-10 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full flex items-center justify-center">
                        <span class="text-sm font-bold text-white">{{ substr(Auth::user()->name ?? 'U', 0, 1) }}</span>
                    </div>

                    <!-- Logout Button -->
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="flex items-center space-x-2 text-gray-500 hover:text-red-600 px-3 py-2 rounded-lg hover:bg-gray-100 transition-colors" title="Logout">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            <span class="hidden lg:inline text-sm">Logout</span>
                        </button>
                    </form>
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden">
                    <button type="button" class="text-gray-700 hover:text-blue-600 p-2" onclick="toggleMobileMenu()">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Mobile User Info -->
            <div id="mobile-menu" class="md:hidden hidden border-t border-gray-200 py-4">
                <div class="px-4">
                    <p class="text-sm text-gray-600">Welcome back,</p>
                    <p class="text-sm font-semibold text-gray-900">{{ Auth::user()->name ?? 'User' }}</p>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content Area -->
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="text-2xl font-bold mb-4">Content Area</h2>
                    <p class="text-gray-600">Silakan isi konten dashboard di sini...</p>
                </div>
            </div>
        </div>
    </div>

    <script>
    function toggleMobileMenu() {
        const menu = document.getElementById('mobile-menu');
        menu.classList.toggle('hidden');
    }

    // Auto hide success notification after 4 seconds
    document.addEventListener('DOMContentLoaded', function() {
        const notification = document.getElementById('success-notification');
        if (notification) {
            setTimeout(function() {
                notification.style.opacity = '0';
                setTimeout(function() {
                    notification.remove();
                }, 300);
            }, 4000);
        }
    });
    </script>
</body>
</html>
