@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-950 via-blue-950 to-slate-950 py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h1 class="text-4xl font-bold bg-gradient-to-r from-amber-400 via-red-400 to-blue-400 bg-clip-text text-transparent">📦 Order Details</h1>
                <p class="text-gray-400 mt-2">Order #{{ $order->id }}</p>
            </div>
            <a href="{{ route('orders.index') }}" class="bg-slate-700 hover:bg-slate-600 text-white font-bold py-3 px-6 rounded-lg transition inline-flex items-center gap-2">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>

        <!-- Success message -->
        @if(session('success'))
            <div class="mb-4 bg-gradient-to-r from-green-900/30 to-emerald-900/30 border-l-4 border-green-500 text-green-300 px-6 py-4 rounded-lg flex items-center mb-6">
                <i class="fas fa-check-circle mr-3 text-green-500"></i>
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Customer Information -->
            <div class="bg-gradient-to-br from-slate-800 to-slate-900 p-6 rounded-xl shadow-xl border border-amber-500/20">
                <h3 class="text-lg font-semibold text-amber-300 mb-4 flex items-center gap-2">
                    <i class="fas fa-user"></i> Customer Information
                </h3>
                <div class="space-y-2 text-sm">
                    <p class="text-slate-300"><strong class="text-amber-300">Name:</strong> <span class="text-slate-400">{{ $order->user?->name ?? 'N/A' }}</span></p>
                    <p class="text-slate-300"><strong class="text-amber-300">Email:</strong> <span class="text-slate-400">{{ $order->user?->email ?? 'N/A' }}</span></p>
                    <p class="text-slate-300"><strong class="text-amber-300">Phone:</strong> <span class="text-slate-400">{{ $order->user?->phone ?? 'N/A' }}</span></p>
                    <p class="text-slate-300"><strong class="text-amber-300">Order Date:</strong> <span class="text-slate-400">{{ $order->created_at->format('M d, Y H:i A') }}</span></p>
                    <p class="text-slate-300"><strong class="text-amber-300">Order ID:</strong> <span class="text-blue-400 font-mono">#{{ $order->id }}</span></p>
                </div>
            </div>

            <!-- Shipping Details -->
            <div class="bg-gradient-to-br from-slate-800 to-slate-900 p-6 rounded-xl shadow-xl border border-amber-500/20">
                <h3 class="text-lg font-semibold text-amber-300 mb-4 flex items-center gap-2">
                    <i class="fas fa-truck"></i> Shipping Details
                </h3>
                <div class="space-y-2 text-sm">
                    <p class="text-slate-300"><strong class="text-amber-300">Address:</strong> <span class="text-slate-400">{{ $order->shipping_address }}</span></p>
                    <p class="text-slate-300"><strong class="text-amber-300">Payment Method:</strong> <span class="text-slate-400">{{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</span></p>
                    <p class="text-slate-300"><strong class="text-amber-300">Order Status:</strong> 
                        @php
                            $statusColor = [
                                'To Pay' => 'bg-yellow-900/40 text-yellow-300 border border-yellow-500/30',
                                'To Ship' => 'bg-blue-900/40 text-blue-300 border border-blue-500/30',
                                'To Receive' => 'bg-purple-900/40 text-purple-300 border border-purple-500/30',
                                'Completed' => 'bg-green-900/40 text-green-300 border border-green-500/30'
                            ];
                            $color = $statusColor[$order->status] ?? 'bg-slate-700/40 text-slate-300 border border-slate-500/30';
                        @endphp
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $color }} ml-2">
                            {{ $order->status }}
                        </span>
                    </p>
                </div>
            </div>
        </div>

        <!-- Order Status Flow -->
        <div class="bg-gradient-to-br from-slate-800 to-slate-900 p-6 rounded-xl shadow-xl border border-amber-500/20 mb-8">
            <h3 class="text-lg font-semibold text-amber-300 mb-6 flex items-center gap-2">
                <i class="fas fa-tasks"></i> Order Progress
            </h3>
            @php
                $statuses = ['To Pay', 'To Ship', 'To Receive', 'Completed'];
                $currentIndex = array_search($order->status, $statuses);
            @endphp
            <div class="flex items-center space-x-2 sm:space-x-4 overflow-x-auto pb-4">
                @foreach ($statuses as $index => $status)
                    <div class="flex items-center flex-shrink-0">
                        <div class="flex flex-col items-center">
                            <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-full 
                                {{ $index <= $currentIndex ? 'bg-gradient-to-r from-amber-500 to-red-600' : 'bg-slate-700' }} 
                                text-white flex items-center justify-center text-xl shadow-lg">
                                @switch($status)
                                    @case('To Pay')
                                        <i class="fas fa-credit-card"></i>
                                    @break
                                    @case('To Ship')
                                        <i class="fas fa-box"></i>
                                    @break
                                    @case('To Receive')
                                        <i class="fas fa-truck"></i>
                                    @break
                                    @case('Completed')
                                        <i class="fas fa-check-circle"></i>
                                    @break
                                @endswitch
                            </div>
                            <span class="text-xs sm:text-sm mt-2 text-center w-14 sm:w-16 text-slate-300">{{ $status }}</span>
                        </div>
                        @if (!$loop->last)
                            <div class="w-4 sm:w-6 h-1 mx-1 sm:mx-2 
                                {{ $index < $currentIndex ? 'bg-gradient-to-r from-amber-500 to-red-600' : 'bg-slate-700' }}"></div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Order Items Table -->
        <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-xl shadow-xl overflow-hidden border border-amber-500/20 mb-8">
            <div class="px-6 py-4 border-b border-amber-500/20 bg-gradient-to-r from-blue-900/40 to-red-900/40">
                <h3 class="text-lg font-semibold text-amber-300 flex items-center gap-2">
                    <i class="fas fa-shopping-cart"></i> Order Items
                </h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-gradient-to-r from-blue-900/40 to-red-900/40 border-b border-amber-500/10">
                        <tr>
                            <th scope="col" class="px-4 sm:px-6 py-3 text-xs font-semibold text-amber-300 uppercase tracking-wider">Product</th>
                            <th scope="col" class="px-4 sm:px-6 py-3 text-xs font-semibold text-amber-300 uppercase tracking-wider">Quantity</th>
                            <th scope="col" class="px-4 sm:px-6 py-3 text-xs font-semibold text-amber-300 uppercase tracking-wider">Price</th>
                            <th scope="col" class="px-4 sm:px-6 py-3 text-xs font-semibold text-amber-300 uppercase tracking-wider">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-amber-500/10">
                        @foreach ($order->orderItems as $item)
                            <tr class="hover:bg-blue-900/20 transition">
                                <td class="px-4 sm:px-6 py-4 flex items-center gap-3">
                                    <img src="{{ asset('storage/'.$item->product->image_path) }}" alt="{{ $item->product->name }}" class="w-12 h-12 object-cover rounded-lg">
                                    <span class="text-slate-300">{{ $item->product->name ?? 'N/A' }}</span>
                                </td>
                                <td class="px-4 sm:px-6 py-4 text-slate-300">{{ $item->quantity }}</td>
                                <td class="px-4 sm:px-6 py-4 text-green-400 font-semibold">₱{{ number_format($item->price, 2) }}</td>
                                <td class="px-4 sm:px-6 py-4 text-green-400 font-semibold">₱{{ number_format($item->price * $item->quantity, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Total Summary -->
            <div class="px-6 py-6 border-t border-amber-500/20 bg-gradient-to-r from-blue-900/40 to-red-900/40 flex justify-end">
                <div class="w-full sm:w-96">
                    <div class="flex justify-between mb-3 pb-3 border-b border-amber-500/20">
                        <span class="text-slate-300">Subtotal:</span>
                        <span class="text-slate-300">₱{{ number_format($order->total, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-lg font-bold">
                        <span class="text-amber-300">Total Amount:</span>
                        <span class="text-yellow-400">₱{{ number_format($order->total, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action buttons -->
        <div class="flex flex-col sm:flex-row gap-3 justify-between">
            <a href="{{ route('orders.index') }}" class="px-6 py-3 bg-slate-700 hover:bg-slate-600 text-white font-bold rounded-lg transition inline-flex items-center justify-center gap-2">
                <i class="fas fa-arrow-left"></i> Back to Orders</a>
            </a>
            
            @if($order->status === 'To Receive')
                <button class="px-6 py-3 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-bold rounded-lg transition inline-flex items-center justify-center gap-2 shadow-lg">
                    <i class="fas fa-check-circle"></i> Confirm Receipt
                </button>
            @endif
            
            <button onclick="window.print()" class="px-6 py-3 bg-gradient-to-r from-blue-600 to-cyan-600 hover:from-blue-700 hover:to-cyan-700 text-white font-bold rounded-lg transition inline-flex items-center justify-center gap-2 shadow-lg">
                <i class="fas fa-print"></i> Print / Save PDF
            </button>
        </div>
    </div>
</div>
@endsection