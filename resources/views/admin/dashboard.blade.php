<!-- resources/views/admin/dashboard.blade.php -->
@extends('layouts.admin')

@section('title', 'Dashboard')

@section('header', 'Dashboard')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <!-- Page Header -->
        <div class="mb-6">
            <h1 class="text-4xl font-bold bg-gradient-to-r from-amber-400 via-red-400 to-blue-400 bg-clip-text text-transparent">Dashboard</h1>
            <p class="text-gray-400 mt-2">Welcome to your admin panel</p>
        </div>

        <!-- Summary Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Orders Summary Card -->
            <div class="bg-gradient-to-br from-slate-800 to-slate-900 p-6 rounded-xl shadow-lg border border-blue-500/20 hover:border-blue-500/40 transition">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-lg font-semibold text-slate-300">Orders</h3>
                    <i class="fas fa-shopping-cart text-blue-400 text-2xl"></i>
                </div>
                <p class="text-4xl font-bold bg-gradient-to-r from-blue-400 to-cyan-400 bg-clip-text text-transparent">{{ $orderCount ?? 0 }}</p>
                <p class="text-slate-400 mt-2 text-sm">Total Orders</p>
                <a href="{{ route('admin.orders.index') }}" class="text-blue-400 hover:text-blue-300 mt-4 inline-block text-sm font-medium">View all orders →</a>
            </div>

            <!-- Products Summary Card -->
            <div class="bg-gradient-to-br from-slate-800 to-slate-900 p-6 rounded-xl shadow-lg border border-green-500/20 hover:border-green-500/40 transition">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-lg font-semibold text-slate-300">Products</h3>
                    <i class="fas fa-box text-green-400 text-2xl"></i>
                </div>
                <p class="text-4xl font-bold bg-gradient-to-r from-green-400 to-emerald-400 bg-clip-text text-transparent">{{ $productCount ?? 0 }}</p>
                <p class="text-slate-400 mt-2 text-sm">Total Products</p>
                <a href="{{ route('admin.products.index') }}" class="text-green-400 hover:text-green-300 mt-4 inline-block text-sm font-medium">Manage products →</a>
            </div>

            <!-- Categories Summary Card -->
            <div class="bg-gradient-to-br from-slate-800 to-slate-900 p-6 rounded-xl shadow-lg border border-purple-500/20 hover:border-purple-500/40 transition">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-lg font-semibold text-slate-300">Categories</h3>
                    <i class="fas fa-layer-group text-purple-400 text-2xl"></i>
                </div>
                <p class="text-4xl font-bold bg-gradient-to-r from-purple-400 to-pink-400 bg-clip-text text-transparent">{{ $categoryCount ?? 0 }}</p>
                <p class="text-slate-400 mt-2 text-sm">Total Categories</p>
                <a href="{{ route('admin.categories.index') }}" class="text-purple-400 hover:text-purple-300 mt-4 inline-block text-sm font-medium">Manage categories →</a>
            </div>

            <!-- Users Summary Card -->
            <div class="bg-gradient-to-br from-slate-800 to-slate-900 p-6 rounded-xl shadow-lg border border-yellow-500/20 hover:border-yellow-500/40 transition">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-lg font-semibold text-slate-300">Users</h3>
                    <i class="fas fa-users text-yellow-400 text-2xl"></i>
                </div>
                <p class="text-4xl font-bold bg-gradient-to-r from-yellow-400 to-amber-400 bg-clip-text text-transparent">{{ $userCount ?? 0 }}</p>
                <p class="text-slate-400 mt-2 text-sm">Registered Users</p>
                <a href="{{ route('admin.users.index') }}" class="text-yellow-400 hover:text-yellow-300 mt-4 inline-block text-sm font-medium">View users →</a>
            </div>
        </div>

        <!-- Recent Orders Section -->
        <div class="bg-gradient-to-br from-slate-800 to-slate-900 shadow-lg rounded-xl overflow-hidden border border-amber-500/20">
            <div class="px-6 py-4 border-b border-amber-500/20 bg-gradient-to-r from-blue-900/40 to-red-900/40">
                <h2 class="text-lg font-semibold text-amber-300">📋 Recent Orders</h2>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-amber-500/10">
                    <thead class="bg-gradient-to-r from-blue-900/40 to-red-900/40">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-amber-300 uppercase tracking-wider">Order ID</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-amber-300 uppercase tracking-wider">Customer</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-amber-300 uppercase tracking-wider">Amount</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-amber-300 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-amber-300 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-amber-300 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-amber-500/10">
                        @forelse($recentOrders ?? [] as $order)
                            <tr class="hover:bg-blue-900/20 transition">
                                <td class="px-6 py-4 whitespace-nowrap text-slate-300">{{ $order->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-slate-300">{{ $order->user->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-green-400 font-semibold">₱{{ number_format($order->total, 2) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $order->status === 'completed' ? 'bg-green-900/40 text-green-300 border border-green-500/30' : 
                                        ($order->status === 'pending' ? 'bg-yellow-900/40 text-yellow-300 border border-yellow-500/30' : 
                                        'bg-slate-700/40 text-slate-300 border border-slate-500/30') }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-slate-400 text-sm">{{ $order->created_at->format('M d, Y') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <a href="{{ route('admin.orders.show', $order->id) }}" class="text-cyan-400 hover:text-cyan-300 font-medium">View</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-slate-400">No recent orders found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection