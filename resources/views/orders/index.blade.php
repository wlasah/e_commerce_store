@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-950 via-blue-950 to-slate-950 py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
            <h1 class="text-4xl font-bold bg-gradient-to-r from-amber-400 via-red-400 to-blue-400 bg-clip-text text-transparent">📦 My Orders</h1>
            <p class="text-gray-400 mt-2">View and track all your orders in one place</p>
        </div>

        <!-- Flash Messages -->
        @if (session('success'))
            <div class="mb-6 bg-gradient-to-r from-green-500 to-emerald-600 text-white rounded-lg p-4 flex items-center gap-3 shadow-lg">
                <i class="fas fa-check-circle text-2xl"></i>
                <p>{{ session('success') }}</p>
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 bg-gradient-to-r from-red-500 to-rose-600 text-white rounded-lg p-4 flex items-center gap-3 shadow-lg">
                <i class="fas fa-exclamation-circle text-2xl"></i>
                <p>{{ session('error') }}</p>
            </div>
        @endif

        @if ($orders->count() > 0)
            <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-xl shadow-xl overflow-hidden border border-amber-500/20">
                <!-- Header -->
                <div class="px-4 sm:px-6 py-4 border-b border-amber-500/20 bg-gradient-to-r from-blue-900/40 to-red-900/40">
                    <div class="flex items-center justify-between flex-col sm:flex-row gap-3">
                        <h3 class="text-lg font-semibold text-amber-300 flex items-center gap-2">
                            <i class="fas fa-history"></i> Order History
                        </h3>
                        <div class="relative w-full sm:w-auto">
                            <input type="text" placeholder="Search orders..." class="px-4 py-2 w-full sm:w-64 bg-slate-900 border border-amber-500/20 text-white rounded-lg focus:border-amber-500 focus:ring-1 focus:ring-amber-500/50 outline-none transition text-sm">
                            <i class="fas fa-search absolute right-3 top-3 text-amber-400"></i>
                        </div>
                    </div>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full divide-y divide-amber-500/10">
                        <thead class="bg-gradient-to-r from-blue-900/40 to-red-900/40">
                            <tr>
                                <th scope="col" class="px-4 sm:px-6 py-3 text-left text-xs font-semibold text-amber-300 uppercase tracking-wider">
                                    Order #
                                </th>
                                <th scope="col" class="px-4 sm:px-6 py-3 text-left text-xs font-semibold text-amber-300 uppercase tracking-wider">
                                    Date
                                </th>
                                <th scope="col" class="px-4 sm:px-6 py-3 text-left text-xs font-semibold text-amber-300 uppercase tracking-wider">
                                    Total
                                </th>
                                <th scope="col" class="px-4 sm:px-6 py-3 text-left text-xs font-semibold text-amber-300 uppercase tracking-wider">
                                    Status
                                </th>
                                <th scope="col" class="px-4 sm:px-6 py-3 text-left text-xs font-semibold text-amber-300 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-amber-500/10">
                            @foreach ($orders as $order)
                                <tr class="hover:bg-blue-900/20 transition">
                                    <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-300">
                                        #{{ $order->id }}
                                    </td>
                                    <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm text-slate-400">
                                        {{ $order->created_at->format('M d, Y') }}
                                    </td>
                                    <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm text-green-400 font-semibold">
                                        ₱{{ number_format($order->total_amount, 2) }}
                                    </td>
                                    <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                        @php
                                            $statusClasses = [
                                                'pending' => 'bg-yellow-900/40 text-yellow-300 border border-yellow-500/30',
                                                'processing' => 'bg-blue-900/40 text-blue-300 border border-blue-500/30',
                                                'completed' => 'bg-green-900/40 text-green-300 border border-green-500/30',
                                                'cancelled' => 'bg-red-900/40 text-red-300 border border-red-500/30',
                                                'To Pay' => 'bg-yellow-900/40 text-yellow-300 border border-yellow-500/30',
                                                'To Ship' => 'bg-blue-900/40 text-blue-300 border border-blue-500/30',
                                                'To Receive' => 'bg-purple-900/40 text-purple-300 border border-purple-500/30',
                                                'Completed' => 'bg-green-900/40 text-green-300 border border-green-500/30'
                                            ];
                                            $statusClass = $statusClasses[$order->status] ?? 'bg-slate-700/40 text-slate-300 border border-slate-500/30';
                                        @endphp
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
                                            <i class="fas fa-circle-notch mr-1"></i> {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm">
                                        <a href="{{ route('orders.show', $order) }}" 
                                           class="px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition inline-flex items-center gap-2 text-xs sm:text-sm font-semibold">
                                            <i class="fas fa-eye"></i> View Details
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="px-6 py-4 border-t border-amber-500/20 bg-gradient-to-r from-slate-800/50 to-slate-900/50">
                    <div class="flex justify-center">
                        {{ $orders->links('pagination::simple-bootstrap-4') }}
                    </div>
                </div>
            </div>
        @else
            <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-xl shadow-xl p-8 border border-amber-500/20 text-center">
                <div class="flex flex-col items-center justify-center py-12">
                    <div class="w-20 h-20 rounded-full bg-amber-500/20 flex items-center justify-center mb-6">
                        <i class="fas fa-shopping-bag text-amber-400 text-4xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-slate-200 mb-2">No Orders Yet</h3>
                    <p class="text-slate-400 mb-6 max-w-md">You haven't placed any orders yet. Start shopping to see your orders here.</p>
                    <a href="{{ route('products.index') }}" class="px-6 py-3 bg-gradient-to-r from-amber-600 to-red-600 hover:from-amber-700 hover:to-red-700 text-white rounded-lg inline-flex items-center gap-2 font-bold transition shadow-lg">
                        <i class="fas fa-shopping-cart"></i> Browse Products
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection