<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVJkEZSMUkrQ6usKu8zIvxUlhasnX7QYnsLtavP9OnGal+QoNz880gZWI9c3eDjYW5Z3Y+6R53ZQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-br from-slate-900 via-blue-900 to-slate-900">
            <!-- Background Effects -->
            <div class="fixed inset-0 overflow-hidden pointer-events-none">
                <div class="absolute top-0 left-1/4 w-96 h-96 bg-amber-500/10 rounded-full blur-3xl"></div>
                <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-blue-500/10 rounded-full blur-3xl"></div>
            </div>

            <!-- Logo Section -->
            <div class="relative z-10">
                <a href="/" class="flex items-center space-x-2">
                    <div class="w-16 h-16 bg-gradient-to-br from-amber-500 to-red-600 rounded-lg flex items-center justify-center shadow-lg">
                        <i class="fas fa-store text-white text-2xl"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold bg-gradient-to-r from-amber-400 via-red-400 to-blue-400 bg-clip-text text-transparent">LMC Store</h1>
                    </div>
                </a>
            </div>

            <!-- Form Container -->
            <div class="w-full sm:max-w-md mt-8 px-6 py-8 bg-gradient-to-br from-slate-800 to-slate-900 shadow-2xl overflow-hidden sm:rounded-2xl border border-amber-500/20 relative z-10">
                {{ $slot }}
            </div>

            <!-- Footer -->
            <div class="mt-8 text-center text-gray-500 text-sm relative z-10">
                <p>© 2026 LMC E-Commerce Store. All rights reserved.</p>
            </div>
        </div>
    </body>
</html>
