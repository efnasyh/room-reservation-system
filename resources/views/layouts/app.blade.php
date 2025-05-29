<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Tab Title -->
    <title>UTHM Campus Event Management System</title>

    <!-- Tab Icon (Favicon) -->
    <link rel="icon" href="{{ asset('uploads/logo/logo_system.png') }}" type="image/png">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Tailwind + App Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Extra Styles for Animations and Effects -->
    <style>
        .header-animate {
            animation: fadeInDown 1s ease;
        }
        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .hover-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        }
        .gradient-bg {
            background: linear-gradient(135deg, #4f46e5, #3b82f6);
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-100">
    <div class="min-h-screen">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @isset($header)
            <header class="bg-white shadow header-animate">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 flex items-center">
                    <!-- Logo -->
                    <img src="{{ asset('uploads/logo/logo_system.png') }}" alt="Logo" class="h-12 w-auto mr-4 rounded-full border-2 border-indigo-500">
                    <!-- Title -->
                    <h1 class="text-2xl font-bold text-gray-800">UTHM Campus Event Management System</h1>
                </div>
            </header>
        @endisset

        <!-- Page Content -->
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-6">
            <div class="grid grid-cols-12 gap-6">
                <!-- Sidebar -->
                <div class="col-span-2">
                    <x-sidebar />
                </div>

                <!-- Main Content -->
                <div class="col-span-10">
                    <div class="bg-white p-6 rounded-2xl shadow-lg hover-card transition-transform duration-300">
                        <main>
                            {{ $slot }}
                        </main>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer (Optional) -->
        <footer class="mt-10 py-4 text-center text-gray-500 text-sm">
            © {{ date('Y') }} UTHM Campus Event Management System. All rights reserved.
        </footer>
    </div>
</body>
</html>
