<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Student Portal')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between">
                <div class="flex space-x-7">
                    <div>
                        <!-- Website Logo -->
                        <a href="{{ route('dashboard') }}" class="flex items-center py-4 px-2">
                            <span class="font-semibold text-gray-500 text-lg">Student Portal</span>
                        </a>
                    </div>
                    <!-- Primary Navbar items -->
                    <div class="hidden md:flex items-center space-x-1">
                        <a href="{{ route('dashboard') }}" class="py-4 px-2 text-gray-500 border-b-4 border-transparent hover:border-green-500 transition duration-300">Dashboard</a>
                        <a href="{{ route('student.enrollment.index') }}" class="py-4 px-2 text-gray-500 border-b-4 border-transparent hover:border-green-500 transition duration-300">Enrollment</a>
                    </div>
                </div>
                <!-- Secondary Navbar items -->
                <div class="hidden md:flex items-center space-x-3">
                    <div class="relative">
                        <button onclick="toggleDropdown()" class="flex items-center text-gray-500 hover:text-gray-700 py-2 px-3 rounded transition duration-300">
                            <span class="mr-2">{{ Auth::user()->name }}</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div id="dropdown" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-2 z-20 hidden">
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center">
                    <button class="outline-none mobile-menu-button">
                        <svg class="w-6 h-6 text-gray-500 hover:text-green-500"
                            x-show="!showMenu"
                            fill="none"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        <!-- mobile menu -->
        <div class="hidden mobile-menu">
            <ul class="">
                <li><a href="{{ route('dashboard') }}" class="block text-sm px-2 py-4 hover:bg-green-500 transition duration-300">Dashboard</a></li>
                <li><a href="{{ route('student.enrollment.index') }}" class="block text-sm px-2 py-4 hover:bg-green-500 transition duration-300">Enrollment</a></li>
                <li><a href="{{ route('profile.edit') }}" class="block text-sm px-2 py-4 hover:bg-green-500 transition duration-300">Profile</a></li>
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full text-left text-sm px-2 py-4 hover:bg-green-500 transition duration-300">
                            Logout
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="py-8">
        @yield('content')
    </main>

    <script>
        function toggleDropdown() {
            document.getElementById('dropdown').classList.toggle('hidden');
        }

        // Mobile menu toggle
        const btn = document.querySelector("button.mobile-menu-button");
        const menu = document.querySelector(".mobile-menu");

        btn.addEventListener("click", () => {
            menu.classList.toggle("hidden");
        });

        // Close dropdown when clicking outside
        window.addEventListener('click', function(e) {
            if (!e.target.matches('.dropdown-button') && !e.target.closest('.relative')) {
                document.getElementById('dropdown').classList.add('hidden');
            }
        });
    </script>
</body>
</html>
