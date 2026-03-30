@extends('layouts.admin')

@section('content')
@php
    use Illuminate\Support\Facades\Storage;
    use Illuminate\Support\Str;
@endphp
<div class="max-w-7xl mx-auto p-6">
    <div class="bg-gradient-to-br from-slate-800 to-slate-900 shadow-lg rounded-xl p-6 border border-amber-500/20">
        <div class="flex justify-between items-center mb-6 pb-6 border-b border-amber-500/20">
            <div>
                <h2 class="text-4xl font-bold bg-gradient-to-r from-amber-400 via-red-400 to-blue-400 bg-clip-text text-transparent">📦 Order #{{ $order->id }}</h2>
                <p class="text-gray-400 text-sm mt-1">Placed on {{ $order->created_at->format('M d, Y') }}</p>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('admin.orders.exportPdf', $order->id) }}" class="px-4 py-2 bg-gradient-to-r from-gray-600 to-gray-700 hover:from-gray-700 hover:to-gray-800 text-white rounded-lg flex items-center shadow-md hover:shadow-lg transition">
                    <i class="fas fa-file-pdf mr-2"></i> Export PDF
                </a>
                
                <!-- Simple inline form for status update -->
                <form method="POST" action="{{ route('admin.orders.updateStatus', $order->id) }}" class="inline-flex items-center space-x-2">
                    @csrf
                    @method('PUT')
                    <select name="status" class="border-2 border-amber-500/30 bg-slate-900/50 text-white rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500 font-medium">
                        <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
                        <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Shipped</option>
                        <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Delivered</option>
                    </select>
                    <button type="submit" class="px-4 py-2 bg-gradient-to-r from-amber-600 to-red-600 hover:from-amber-700 hover:to-red-700 text-white rounded-lg flex items-center shadow-md hover:shadow-lg transition">
                        <i class="fas fa-save mr-2"></i> Update
                    </button>
                </form>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-4 p-4 bg-gradient-to-r from-green-900/30 to-emerald-900/30 text-green-300 rounded-lg border-l-4 border-green-500">
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-3 text-green-400"></i>
                    {{ session('success') }}
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 p-4 bg-gradient-to-r from-red-900/30 to-rose-900/30 text-red-300 rounded-lg border-l-4 border-red-500">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle mr-3 text-red-400"></i>
                    {{ session('error') }}
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <!-- Customer Information -->
            <div class="bg-gradient-to-br from-amber-900/30 to-yellow-900/30 p-5 rounded-lg border border-amber-500/30">
                <h3 class="text-lg font-semibold mb-4 border-b pb-3 border-amber-500/30 text-amber-300 flex items-center">
                    <i class="fas fa-user-circle mr-2 text-amber-400"></i> 👤 Customer Information
                </h3>
                <div class="space-y-3">
                    <div>
                        <span class="font-medium text-gray-400">Name:</span>
                        <p class="text-white">{{ $order->user?->name ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <span class="font-medium text-gray-400">Email:</span>
                        <p class="text-white break-all text-sm">{{ $order->user?->email ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <span class="font-medium text-gray-400">Order Date:</span>
                        <p class="text-white">{{ $order->created_at->format('M d, Y h:i A') }}</p>
                    </div>
                </div>
            </div>

            <!-- Shipping Information -->
            <div class="bg-gradient-to-br from-red-900/30 to-orange-900/30 p-5 rounded-lg border border-red-500/30">
                <h3 class="text-lg font-semibold mb-4 border-b pb-3 border-red-500/30 text-red-300 flex items-center">
                    <i class="fas fa-shipping-fast mr-2 text-red-400"></i> 🚚 Shipping Details
                </h3>
                <div class="space-y-3">
                    <div>
                        <span class="font-medium text-gray-400">Address:</span>
                        <p class="text-white">{{ $order->shipping_address }}</p>
                    </div>
                    <div>
                        <span class="font-medium text-gray-400">Payment Method:</span>
                        <p class="text-white">{{ $order->payment_method }}</p>
                    </div>
                    <div>
                        <span class="font-medium text-gray-400">Order Status:</span>
                        <p class="mt-1">
                            @php
                                $statusIcons = [
                                    'pending' => 'fas fa-clock',
                                    'processing' => 'fas fa-cogs',
                                    'shipped' => 'fas fa-truck',
                                    'delivered' => 'fas fa-check-circle'
                                ];
                                $statusClasses = [
                                    'pending' => 'bg-yellow-500/30 text-yellow-300 border-yellow-500/30',
                                    'processing' => 'bg-blue-500/30 text-blue-300 border-blue-500/30',
                                    'shipped' => 'bg-purple-500/30 text-purple-300 border-purple-500/30',
                                    'delivered' => 'bg-green-500/30 text-green-300 border-green-500/30'
                                ];
                            @endphp
                            <span class="px-3 py-1 rounded-full inline-flex items-center border {{ $statusClasses[$order->status] ?? 'bg-gray-500/30 text-gray-300 border-gray-500/30' }}">
                                <i class="{{ $statusIcons[$order->status] ?? 'fas fa-info-circle' }} mr-2"></i>
                                {{ ucfirst($order->status) }}
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Status Flow -->
        <div class="mb-8 bg-gradient-to-br from-blue-900/20 to-red-900/20 p-6 rounded-lg border border-amber-500/20">
            <h3 class="text-lg font-bold text-amber-300 mb-4">📊 Order Progress</h3>
            @php
                $statuses = ['pending', 'processing', 'shipped', 'delivered'];
                $statusLabels = ['Pending', 'Processing', 'Shipped', 'Delivered'];
                $statusIcons = ['fa-clock', 'fa-cogs', 'fa-truck', 'fa-check-circle'];
                $currentIndex = array_search($order->status, $statuses);
            @endphp
            <div class="relative">
                <!-- Progress Bar Background -->
                <div class="h-2 bg-slate-700 rounded-full absolute top-5 start-0 w-full z-0"></div>
                
                <!-- Progress Bar Fill -->
                @if($currentIndex >= 0)
                <div class="h-2 bg-gradient-to-r from-green-500 to-emerald-600 rounded-full absolute top-5 start-0 z-10" 
                     style="width: {{ ($currentIndex / (count($statuses) - 1)) * 100 }}%"></div>
                @endif
                
                <!-- Status Points -->
                <div class="flex justify-between relative z-20">
                    @foreach($statuses as $index => $status)
                    <div class="flex flex-col items-center w-24">
                        <div class="w-12 h-12 rounded-full flex items-center justify-center
                            @if($index < $currentIndex)
                                bg-gradient-to-r from-amber-500 to-red-600 text-white
                            @elseif($index == $currentIndex)
                                bg-gradient-to-r from-blue-500 to-cyan-500 text-white
                            @else
                                bg-slate-600 text-gray-400
                            @endif
                            shadow-lg">
                            <i class="fas {{ $statusIcons[$index] }} text-lg"></i>
                        </div>
                        <span class="text-xs mt-2 text-center text-gray-300">{{ $statusLabels[$index] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Order Items Table -->
        <div class="mb-8">
            <h3 class="text-xl font-semibold mb-4 text-amber-300 flex items-center">
                <i class="fas fa-shopping-bag mr-2 text-amber-400"></i> 📦 Order Items
            </h3>
            <div class="overflow-x-auto rounded-lg shadow-lg border border-amber-500/20">
                <table class="w-full text-sm text-left">
                    <thead class="text-xs uppercase bg-gradient-to-r from-blue-900/40 to-red-900/40 text-amber-300 font-semibold border-b border-amber-500/20">
                        <tr>
                            <th class="px-6 py-3">Product</th>
                            <th class="px-6 py-3">Quantity</th>
                            <th class="px-6 py-3">Price</th>
                            <th class="px-6 py-3">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="bg-gradient-to-b from-slate-800 to-slate-900 divide-y divide-amber-500/10">
                        @foreach ($order->orderItems as $item)
                            <tr class="hover:bg-blue-900/20 transition">
                                <td class="px-6 py-4 flex items-center">
                                    @if($item->product && $item->product->image_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($item->product->image_path))
                                        <img src="{{ asset('storage/' . $item->product->image_path) }}" alt="{{ $item->product->name }}" class="w-16 h-16 object-cover rounded mr-4" loading="lazy">
                                    @else
                                        <div class="w-16 h-16 bg-gradient-to-br from-amber-500/30 to-red-500/30 rounded flex items-center justify-center mr-4 border border-amber-500/20">
                                            <i class="fas fa-image text-2xl text-amber-400"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <p class="font-medium text-white">{{ $item->product->name ?? 'N/A' }}</p>
                                        @if($item->product && $item->product->sku)
                                            <p class="text-xs text-gray-400">SKU: {{ $item->product->sku }}</p>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-white font-medium">{{ $item->quantity }}</td>
                                <td class="px-6 py-4 text-white">₱{{ number_format($item->price, 2) }}</td>
                                <td class="px-6 py-4 font-bold text-green-400">₱{{ number_format($item->price * $item->quantity, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="bg-gradient-to-r from-slate-700 to-slate-800 border-t-2 border-amber-500/30">
                            <td colspan="3" class="px-6 py-3 text-right font-semibold text-amber-300">Subtotal:</td>
                            <td class="px-6 py-3 font-bold text-white">₱{{ number_format($order->orderItems->sum(function($item) { 
                                return $item->price * $item->quantity; 
                            }), 2) }}</td>
                        </tr>

                        <tr class="bg-gradient-to-r from-amber-600 to-red-600">
                            <td colspan="3" class="px-6 py-4 text-right font-bold text-white">💵 Total:</td>
                            <td class="px-6 py-4 font-bold text-white text-lg">₱{{ number_format($order->total_amount, 2) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>



        <!-- Back to Orders List -->
        <div class="mt-6">
            <a href="{{ route('admin.orders.index') }}" class="text-amber-400 hover:text-amber-300 transition flex items-center font-semibold">
                <i class="fas fa-arrow-left mr-2"></i> ← Back to Orders List
            </a>
        </div>
    </div>
</div>
@endsection