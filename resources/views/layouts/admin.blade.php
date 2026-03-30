
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'L.M.C') }} Admin - @yield('title', 'Dashboard')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased min-h-screen bg-gradient-to-br from-slate-950 via-slate-900 to-blue-950">
    <div class="flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-gradient-to-b from-slate-900 via-blue-900/50 to-slate-900 text-white h-screen fixed shadow-2xl border-r border-amber-500/20">
    <div class="px-4 py-5">
        <div class="flex items-center space-x-2">
            <div class="bg-gradient-to-br from-amber-500 to-red-600 p-2 rounded-lg">
                <span class="text-white font-bold text-lg">LMC</span>
            </div>
            <div>
                <h1 class="text-xl font-bold bg-gradient-to-r from-amber-400 to-red-400 bg-clip-text text-transparent">Admin</h1>
                <p class="text-xs text-gray-400">Dashboard</p>
            </div>
        </div>

        <!-- Admin Avatar and Name -->
        <div class="flex items-center mt-6 p-3 rounded-lg bg-amber-500/10 border border-amber-500/20 hover:bg-amber-500/20 transition">
            @if (auth()->user()->avatar)
                <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="Avatar" class="rounded-full w-10 h-10 ring-2 ring-amber-500">
            @else
                <div class="rounded-full w-10 h-10 bg-gradient-to-br from-amber-500 to-red-600 flex items-center justify-center text-white font-bold">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
            @endif
            <div class="ml-3">
                <span class="text-sm font-semibold">{{ auth()->user()->name }}</span>
                <p class="text-xs text-gray-400">Administrator</p>
            </div>
        </div>
    </div>

    <nav class="mt-8">
        <ul class="space-y-1 px-2">
            <li>
    <a href="{{ route('admin.profile.edit') }}" class="block px-4 py-3 rounded-lg {{ request()->routeIs('admin.profile.edit') ? 'bg-gradient-to-r from-amber-500/30 to-red-500/30 border border-amber-500/50 text-amber-300' : 'text-gray-300 hover:bg-amber-500/10 hover:text-amber-300' }} transition">
        <i class="fas fa-user-circle mr-2"></i>Profile
    </a>
</li>

            <li>
                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-3 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-gradient-to-r from-amber-500/30 to-red-500/30 border border-amber-500/50 text-amber-300' : 'text-gray-300 hover:bg-amber-500/10 hover:text-amber-300' }} transition">
                    <i class="fas fa-chart-line mr-2"></i>Dashboard
                </a>
            </li>
            <li>
                <a href="{{ route('admin.products.index') }}" class="block px-4 py-3 rounded-lg {{ request()->routeIs('admin.products.*') ? 'bg-gradient-to-r from-amber-500/30 to-red-500/30 border border-amber-500/50 text-amber-300' : 'text-gray-300 hover:bg-amber-500/10 hover:text-amber-300' }} transition">
                    <i class="fas fa-box mr-2"></i>Products
                </a>
            </li>
            <li>
                <a href="{{ route('admin.categories.index') }}" class="block px-4 py-3 rounded-lg {{ request()->routeIs('admin.categories.*') ? 'bg-gradient-to-r from-amber-500/30 to-red-500/30 border border-amber-500/50 text-amber-300' : 'text-gray-300 hover:bg-amber-500/10 hover:text-amber-300' }} transition">
                    <i class="fas fa-list mr-2"></i>Categories
                </a>
            </li>
            <li>
                <a href="{{ route('admin.orders.index') }}" class="block px-4 py-3 rounded-lg {{ request()->routeIs('admin.orders.*') ? 'bg-gradient-to-r from-amber-500/30 to-red-500/30 border border-amber-500/50 text-amber-300' : 'text-gray-300 hover:bg-amber-500/10 hover:text-amber-300' }} transition">
                    <i class="fas fa-shopping-cart mr-2"></i>Orders
                </a>
            </li>
            <li class="mt-8 pt-4 border-t border-amber-500/20">
                <a href="{{ route('home') }}" class="block px-4 py-3 rounded-lg text-gray-300 hover:bg-gradient-to-r hover:from-cyan-500/20 hover:to-blue-500/20 hover:text-cyan-300 transition">
                    <i class="fas fa-arrow-left mr-2"></i>Back to Shop
                </a>
            </li>
        </ul>
    </nav>
</aside>

        <!-- Main Content -->
        <main class="flex-1 ml-64 p-8">
            <!-- Flash Messages -->
            @if (session('success'))
                <div class="bg-gradient-to-r from-green-900/30 to-emerald-900/30 border border-green-500/50 text-green-300 px-6 py-4 rounded-lg mb-6 flex items-center backdrop-blur shadow-lg" role="alert">
                    <i class="fas fa-check-circle mr-3 text-green-400 text-lg"></i>
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div class="bg-gradient-to-r from-red-900/30 to-rose-900/30 border border-red-500/50 text-red-300 px-6 py-4 rounded-lg mb-6 flex items-center backdrop-blur shadow-lg" role="alert">
                    <i class="fas fa-exclamation-circle mr-3 text-red-400 text-lg"></i>
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-4xl font-bold bg-gradient-to-r from-amber-400 via-red-400 to-blue-400 bg-clip-text text-transparent">@yield('header', 'Dashboard')</h1>
                <p class="text-gray-400 mt-2">Welcome to your admin panel</p>
            </div>

            <!-- Content -->
            @yield('content')
        </main>
    </div>
</body>
</html>
```