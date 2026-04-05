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
                <p class="text-gray-400 text-sm mt-1">Placed on {{ $order->created_at->format('M d, Y h:i A') }}</p>
            </div>
            <div class="flex space-x-3 items-center">
                <a href="{{ route('admin.orders.exportPdf', $order->id) }}" class="px-4 py-2 bg-gradient-to-r from-gray-600 to-gray-700 hover:from-gray-700 hover:to-gray-800 text-white rounded-lg flex items-center shadow-md hover:shadow-lg transition">
                    <i class="fas fa-file-pdf mr-2"></i> Export PDF
                </a>
                
                <!-- Improved Status Dropdown -->
                <div class="group relative">
                    <button type="button" class="px-4 py-2 bg-gradient-to-r from-amber-600 to-red-600 hover:from-amber-700 hover:to-red-700 text-white rounded-lg flex items-center shadow-md hover:shadow-lg transition font-semibold">
                        <i class="fas fa-edit mr-2"></i> Status: <span class="ml-1 capitalize">{{ $order->status }}</span>
                        <i class="fas fa-chevron-down ml-2 text-sm group-hover:rotate-180 transition-transform"></i>
                    </button>
                    
                    <!-- Dropdown Menu -->
                    <div class="absolute right-0 mt-2 w-48 bg-slate-800 rounded-lg shadow-xl border border-amber-500/30 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-40 overflow-hidden">
                        @php
                            $statuses = ['pending', 'processing', 'shipped', 'delivered'];
                            $statusLabels = ['Pending', 'Processing', 'Shipped', 'Delivered'];
                            $statusIcons = ['fa-clock', 'fa-cogs', 'fa-truck', 'fa-check-circle'];
                        @endphp
                        @foreach($statuses as $index => $status)
                        <form method="POST" action="{{ route('admin.orders.updateStatus', $order->id) }}" class="block">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="{{ $status }}">
                            <button type="submit" class="w-full text-left px-4 py-3 hover:bg-blue-900/40 transition {{ $order->status === $status ? 'bg-blue-900/60 border-l-4 border-amber-500' : '' }}">
                                <i class="fas {{ $statusIcons[$index] }} mr-2 {{ $order->status === $status ? 'text-amber-400' : 'text-gray-400' }}"></i>
                                <span class="text-white {{ $order->status === $status ? 'font-semibold text-amber-300' : '' }}">{{ $statusLabels[$index] }}</span>
                                @if($order->status === $status)
                                    <i class="fas fa-check float-right text-amber-400"></i>
                                @endif
                            </button>
                        </form>
                        @endforeach
                    </div>
                </div>
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

        <!-- Order Status Flow - Interactive -->
        <div class="mb-8 bg-gradient-to-br from-blue-900/20 to-red-900/20 p-6 rounded-lg border border-amber-500/20">
            <h3 class="text-lg font-bold text-amber-300 mb-6 flex items-center">
                <i class="fas fa-tasks mr-2"></i> 📊 Order Progress
            </h3>
            @php
                $statuses = ['pending', 'processing', 'shipped', 'delivered'];
                $statusLabels = ['📋 Pending', '⚙️ Processing', '🚚 Shipped', '✅ Delivered'];
                $statusIcons = ['fa-clock', 'fa-cogs', 'fa-truck', 'fa-check-circle'];
                $statusColors = [
                    'pending' => 'yellow',
                    'processing' => 'blue',
                    'shipped' => 'purple',
                    'delivered' => 'green'
                ];
                $currentIndex = array_search($order->status, $statuses);
                $progressWidth = ($currentIndex >= 0) ? ($currentIndex / (count($statuses) - 1)) * 100 : 0;
            @endphp
            <div class="relative">
                <!-- Progress Bar Background -->
                <div class="h-3 bg-slate-700 rounded-full absolute top-6 start-0 w-full z-0"></div>
                
                <!-- Progress Bar Fill -->
                @if($currentIndex >= 0)
                <div class="h-3 bg-gradient-to-r from-green-500 to-emerald-600 rounded-full absolute top-6 start-0 z-10 transition-all duration-500 progress-bar" 
                     data-progress="{{ $progressWidth }}"></div>
                @endif
                
                <!-- Status Points - Clickable -->
                <div class="flex justify-between relative z-20">
                    @foreach($statuses as $index => $status)
                    @php
                        $isCompleted = $index < $currentIndex;
                        $isCurrent = $index == $currentIndex;
                        $isFuture = $index > $currentIndex;
                    @endphp
                    <form method="POST" action="{{ route('admin.orders.updateStatus', $order->id) }}" class="inline-block" id="form-{{ $status }}">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" value="{{ $status }}">
                        
                        <button type="submit" 
                            {{ $isCompleted ? 'disabled title="Status already completed"' : '' }}
                            class="flex flex-col items-center w-24 group transition-all duration-300 {{ $isCompleted ? 'cursor-not-allowed' : 'cursor-pointer hover:scale-110' }}">
                            <div class="w-14 h-14 rounded-full flex items-center justify-center shadow-lg transition-all duration-300 transform {{ !$isCompleted ? 'group-hover:shadow-2xl group-hover:scale-105' : '' }}
                                @if($isCompleted)
                                    bg-gradient-to-br from-amber-500 to-red-600 text-white
                                @elseif($isCurrent)
                                    bg-gradient-to-br from-blue-500 to-cyan-500 text-white ring-4 ring-cyan-400/50 group-hover:ring-cyan-400/80
                                @else
                                    bg-slate-700 text-gray-400 group-hover:bg-slate-600 group-hover:text-gray-300 {{ $isFuture ? 'group-hover:bg-slate-500' : '' }}
                                @endif
                                ">
                                <i class="fas {{ $statusIcons[$index] }} text-xl"></i>
                            </div>
                            <span class="text-sm mt-3 text-center font-semibold {{ $isCurrent ? 'text-white' : 'text-gray-300 group-hover:text-white' }} transition-all duration-200">
                                {{ $statusLabels[$index] }}
                            </span>
                            @if($isCompleted)
                                <span class="text-xs mt-1 text-green-400 font-semibold">
                                    <i class="fas fa-check-circle"></i> Completed
                                </span>
                            @elseif($isCurrent)
                                <span class="text-xs mt-1 text-blue-300 font-semibold">
                                    <i class="fas fa-circle"></i> Current
                                </span>
                            @else
                                <span class="text-xs mt-1 text-amber-400 opacity-0 group-hover:opacity-100 transition-opacity font-semibold">
                                    <i class="fas fa-arrow-right"></i> Next
                                </span>
                            @endif
                        </button>
                    </form>
                    @endforeach
                </div>
                
                <!-- Status Timeline Info -->
                <div class="mt-8 pt-6 border-t border-amber-500/20">
                    <p class="text-sm text-slate-400 mb-4 font-semibold">
                        <i class="fas fa-info-circle mr-2 text-amber-400"></i>
                        Click on any upcoming status to advance the order. Statuses move: Pending → Processing → Shipped → Delivered
                    </p>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        @foreach($statuses as $index => $status)
                        @php
                            $completed = $index < $currentIndex;
                            $active = $index == $currentIndex;
                        @endphp
                        <div class="p-3 rounded-lg bg-slate-800/50 border {{ $completed || $active ? 'border-amber-500/50' : 'border-slate-600/50' }} transition-all hover:border-amber-500/70">
                            <div class="flex items-center mb-2">
                                <i class="fas {{ $statusIcons[$index] }} text-lg mr-2 
                                    {{ $completed || $active ? 'text-amber-400' : 'text-slate-500' }}"></i>
                                <span class="font-semibold text-sm {{ $completed || $active ? 'text-amber-300' : 'text-slate-400' }}">
                                    {{ $statusLabels[$index] }}
                                </span>
                            </div>
                            <p class="text-xs text-slate-400 ml-6">
                                @if($completed)
                                    <span class="text-green-400 font-semibold">✓ Completed</span>
                                @elseif($active)
                                    <span class="text-blue-400 font-semibold">◐ Current Status</span>
                                @else
                                    <span class="text-slate-500">⊘ Pending</span>
                                @endif
                            </p>
                        </div>
                        @endforeach
                    </div>
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

<script>
    // Set progress bar widths from data attributes
    document.querySelectorAll('.progress-bar').forEach(bar => {
        const width = bar.getAttribute('data-progress');
        if (width) {
            bar.style.width = width + '%';
        }
    });
</script>
@endsection