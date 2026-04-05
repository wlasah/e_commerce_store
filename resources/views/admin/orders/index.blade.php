@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <!-- Page Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-4xl font-bold bg-gradient-to-r from-amber-400 via-red-400 to-blue-400 bg-clip-text text-transparent">📦 Manage Orders</h1>
            <p class="text-gray-400 mt-2">Track and manage customer orders</p>
        </div>
        <div class="flex space-x-2">
            <a href="#" class="px-4 py-2 bg-gradient-to-r from-cyan-600 to-blue-600 hover:from-cyan-700 hover:to-blue-700 text-white rounded-lg font-medium flex items-center shadow-lg hover:shadow-xl transition">
                <i class="fas fa-file-export mr-2"></i> Export Orders
            </a>
            <a href="#" class="px-4 py-2 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white rounded-lg font-medium flex items-center shadow-lg hover:shadow-xl transition">
                <i class="fas fa-chart-line mr-2"></i> Sales Report
            </a>
        </div>
    </div>

    <!-- Flash Messages -->
    @if (session('success'))
        <div class="bg-gradient-to-r from-green-900/30 to-emerald-900/30 dark:from-green-900 dark:to-emerald-900 border-l-4 border-green-500 text-green-300 p-4 mb-6 rounded-lg shadow-sm">
            <div class="flex items-center">
                <i class="fas fa-check-circle mr-3 text-green-400"></i>
                <p>{{ session('success') }}</p>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="bg-gradient-to-r from-red-900/30 to-rose-900/30 dark:from-red-900 dark:to-rose-900 border-l-4 border-red-500 text-red-300 p-4 mb-6 rounded-lg shadow-sm">
            <div class="flex items-center">
                <i class="fas fa-exclamation-circle mr-3 text-red-400"></i>
                <p>{{ session('error') }}</p>
            </div>
        </div>
    @endif

    <!-- Orders Table -->
    <div class="bg-gradient-to-br from-slate-800 to-slate-900 shadow-lg rounded-xl overflow-hidden border border-amber-500/20">
        <div class="px-6 py-4 border-b border-amber-500/20 flex justify-between items-center bg-gradient-to-r from-blue-900/40 to-red-900/40">
            <h2 class="text-lg font-semibold text-amber-300">All Orders</h2>
            
            <!-- Search and Filter -->
            <div class="flex items-center space-x-4">
                <div class="relative">
                    <input type="text" placeholder="Search orders..." class="px-4 py-2 rounded-lg border border-amber-500/30 dark:bg-slate-900/50 dark:text-white focus:outline-none focus:ring-2 focus:ring-amber-500/50 shadow-sm">
                    <i class="fas fa-search absolute right-3 top-3 text-gray-400"></i>
                </div>
                <select class="px-4 py-2 rounded-lg border border-amber-500/30 dark:bg-slate-900/50 dark:text-white focus:outline-none focus:ring-2 focus:ring-amber-500/50 shadow-sm">
                    <option value="">Filter by Status</option>
                    <option value="pending">Pending</option>
                    <option value="processing">Processing</option>
                    <option value="completed">Completed</option>
                    <option value="shipped">Shipped</option>
                </select>
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-amber-500/10">
                <thead class="bg-gradient-to-r from-blue-900/40 to-red-900/40">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-amber-300 uppercase tracking-wider">
                            📋 Order ID
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-amber-300 uppercase tracking-wider">
                            👤 Customer
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-amber-300 uppercase tracking-wider">
                            💵 Total Amount
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-amber-300 uppercase tracking-wider">
                            📊 Status
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-amber-300 uppercase tracking-wider">
                            📅 Date
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-amber-300 uppercase tracking-wider">
                            ⚙️ Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-gradient-to-b from-slate-800 to-slate-900 divide-y divide-amber-500/10">
                    @forelse ($orders as $order)
                        <tr class="hover:bg-blue-900/20 transition">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-amber-300">
                                #{{ $order->id }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-8 w-8">
                                        <div class="h-8 w-8 rounded-full bg-gradient-to-br from-amber-500 to-red-600 flex items-center justify-center text-white font-semibold text-sm">
                                            {{ substr($order->user->name, 0, 1) }}
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-white">
                                            {{ $order->user->name }}
                                        </div>
                                        <div class="text-sm text-gray-400">
                                            {{ $order->user->email }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-200">
                                <span class="font-bold text-green-400">₱{{ number_format($order->total_amount, 2) }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $statusClasses = [
                                        'To Pay' => 'bg-yellow-500/30 text-yellow-300 border-yellow-500/30',
                                        'To Ship' => 'bg-blue-500/30 text-blue-300 border-blue-500/30',
                                        'To Receive' => 'bg-purple-500/30 text-purple-300 border-purple-500/30',
                                        'Completed' => 'bg-green-500/30 text-green-300 border-green-500/30',
                                        'pending' => 'bg-yellow-500/30 text-yellow-300 border-yellow-500/30',
                                        'processing' => 'bg-blue-500/30 text-blue-300 border-blue-500/30',
                                        'completed' => 'bg-green-500/30 text-green-300 border-green-500/30',
                                        'shipped' => 'bg-purple-500/30 text-purple-300 border-purple-500/30',
                                        'cancelled' => 'bg-red-500/30 text-red-300 border-red-500/30',
                                    ];
                                    $statusClass = $statusClasses[$order->status] ?? 'bg-gray-500/30 text-gray-300 border-gray-500/30';
                                @endphp
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full border {{ $statusClass }}">
                                    {{ $order->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                {{ $order->created_at->format('M d, Y h:i A') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <div class="flex space-x-2 items-center">
                                    <a href="{{ route('admin.orders.show', $order) }}" class="px-3 py-1 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white rounded-lg flex items-center shadow-sm hover:shadow-md transition text-xs">
                                        <i class="fas fa-eye mr-1"></i> View
                                    </a>
                                    <!-- Status Dropdown with JavaScript -->
                                    <div class="status-dropdown-container-{{ $order->id }}">
                                        <button type="button" class="px-3 py-1 bg-gradient-to-r from-amber-600 to-red-600 hover:from-amber-700 hover:to-red-700 text-white rounded-lg flex items-center shadow-sm hover:shadow-md transition text-xs font-semibold status-btn-{{ $order->id }}" onclick="toggleStatusDropdown('{{ $order->id }}', event)">
                                            <i class="fas fa-edit mr-1"></i> Status
                                            <i class="fas fa-chevron-down ml-1 text-xs status-chevron-{{ $order->id }} transition-transform"></i>
                                        </button>
                                    </div>
                                    
                                    <!-- Dropdown Menu - Fixed Position to avoid scrolling -->
                                    <div class="fixed hidden status-menu-{{ $order->id }} z-50 bg-slate-800 rounded-lg shadow-2xl border border-amber-500/30 w-48" style="pointer-events: auto; top: auto; left: auto;">
                                        @php
                                            $statuses = ['pending', 'processing', 'shipped', 'delivered'];
                                            $statusLabels = ['Pending', 'Processing', 'Shipped', 'Delivered'];
                                            $statusIcons = ['fa-clock', 'fa-cogs', 'fa-truck', 'fa-check-circle'];
                                        @endphp
                                        @foreach($statuses as $index => $status)
                                        <form method="POST" action="{{ route('admin.orders.updateStatus', $order->id) }}" class="block" onsubmit="closeStatusDropdown('{{ $order->id }}')">>
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="{{ $status }}">
                                            <button type="submit" class="w-full text-left px-4 py-3 hover:bg-blue-900/50 transition {{ $order->status === $status ? 'bg-blue-900/60 border-l-4 border-amber-500' : 'border-l-4 border-transparent' }} flex items-center justify-between">
                                                <span class="flex items-center">
                                                    <i class="fas {{ $statusIcons[$index] }} mr-2 {{ $order->status === $status ? 'text-amber-400' : 'text-gray-400' }}"></i>
                                                    <span class="text-white text-sm {{ $order->status === $status ? 'font-semibold text-amber-300' : '' }}">
                                                        {{ $statusLabels[$index] }}
                                                    </span>
                                                </span>
                                                @if($order->status === $status)
                                                    <i class="fas fa-check text-amber-400 text-xs ml-2"></i>
                                                @endif
                                            </button>
                                        </form>
                                        @endforeach
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 whitespace-nowrap text-sm text-gray-400 text-center">
                                <i class="fas fa-inbox text-3xl mb-2 block text-gray-500"></i>
                                No orders found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-amber-500/20 bg-slate-800/50">
            {{ $orders->links() }}
        </div>
    </div>
</div>

<script>
    function toggleStatusDropdown(orderId, event) {
        event.stopPropagation();
        const btn = document.querySelector(`.status-btn-${orderId}`);
        const menu = document.querySelector(`.status-menu-${orderId}`);
        const chevron = document.querySelector(`.status-chevron-${orderId}`);
        
        // Close other dropdowns
        document.querySelectorAll('[class*="status-menu-"]').forEach(m => {
            if (!m.classList.contains(`status-menu-${orderId}`)) {
                m.classList.add('hidden');
            }
        });
        
        // Toggle current dropdown
        const isHidden = menu.classList.toggle('hidden');
        chevron.style.transform = isHidden ? 'rotate(0deg)' : 'rotate(180deg)';
        
        // Position the menu at the button location
        if (!isHidden) {
            positionDropdown(orderId, btn, menu);
        }
    }

    function positionDropdown(orderId, btn, menu) {
        const rect = btn.getBoundingClientRect();
        menu.style.top = (rect.bottom + 8) + 'px';
        menu.style.left = (rect.right - 192) + 'px'; // 192px is w-48
    }

    function closeStatusDropdown(orderId) {
        const menu = document.querySelector(`.status-menu-${orderId}`);
        const chevron = document.querySelector(`.status-chevron-${orderId}`);
        menu.classList.add('hidden');
        chevron.style.transform = 'rotate(0deg)';
    }

    // Close dropdown when clicking outside
    document.addEventListener('click', function(event) {
        document.querySelectorAll('[class*="status-menu-"]').forEach(menu => {
            const orderId = menu.className.match(/status-menu-(\d+)/)[1];
            const container = document.querySelector(`.status-dropdown-container-${orderId}`);
            
            if (!container?.contains(event.target) && !menu.contains(event.target)) {
                menu.classList.add('hidden');
                const chevron = document.querySelector(`.status-chevron-${orderId}`);
                if (chevron) chevron.style.transform = 'rotate(0deg)';
            }
        });
    });

    // Reposition dropdowns on scroll
    window.addEventListener('scroll', function() {
        document.querySelectorAll('[class*="status-menu-"]:not(.hidden)').forEach(menu => {
            const orderId = menu.className.match(/status-menu-(\d+)/)[1];
            const btn = document.querySelector(`.status-btn-${orderId}`);
            if (btn) {
                positionDropdown(orderId, btn, menu);
            }
        });
    }, true);
</script>

@endsection