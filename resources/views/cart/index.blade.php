@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-950 via-blue-950 to-slate-950">
    <div class="container mx-auto px-4 py-8">
        <div class="mb-6">
            <h1 class="text-4xl font-bold bg-gradient-to-r from-amber-400 via-red-400 to-blue-400 bg-clip-text text-transparent">🛒 Shopping Cart</h1>
            <p class="text-gray-300 mt-2">Review and manage your items</p>
        </div>
        
        <!-- Success Message -->
        @if(session('success'))
            <div class="bg-gradient-to-r from-green-900/30 to-emerald-900/30 border-l-4 border-green-500 text-green-300 px-4 py-3 rounded-lg mb-4 flex items-center">
                <i class="fas fa-check-circle mr-2"></i>
                {{ session('success') }}
            </div>
        @endif
        
        <!-- Error Message -->
        @if(session('error'))
            <div class="bg-gradient-to-r from-red-900/30 to-rose-900/30 border-l-4 border-red-500 text-red-300 px-4 py-3 rounded-lg mb-4 flex items-center">
                <i class="fas fa-exclamation-circle mr-2"></i>
                {{ session('error') }}
            </div>
        @endif
        
        @if($cartItems->count() > 0)
            <!-- Cart Table -->
            <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-xl shadow-2xl overflow-hidden border border-amber-500/20">
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-gradient-to-r from-blue-900/40 to-red-900/40 border-b border-amber-500/20">
                            <tr>
                                <th class="px-6 py-4 text-amber-300 font-semibold">📦 Product</th>
                                <th class="px-6 py-4 text-amber-300 font-semibold">💵 Price</th>
                                <th class="px-6 py-4 text-amber-300 font-semibold">📊 Quantity</th>
                                <th class="px-6 py-4 text-amber-300 font-semibold">💰 Total</th>
                                <th class="px-6 py-4 text-amber-300 font-semibold">⚙️ Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-amber-500/10">
                            @foreach($cartItems as $item)
                                <tr class="hover:bg-purple-900/20 transition">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center space-x-4">
                                            <div class="w-20 h-20 rounded-lg overflow-hidden flex-shrink-0 shadow-md border border-amber-500/20">
                                                @if($item->product->image_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($item->product->image_path))
                                                    <img src="{{ asset('storage/' . $item->product->image_path) }}" 
                                                         alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                                                @else
                                                    <div class="w-full h-full bg-gradient-to-br from-amber-500/30 to-red-500/30 flex items-center justify-center">
                                                        <i class="fas fa-image text-lg text-amber-400"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <div>
                                                <h3 class="font-bold text-white text-lg">{{ $item->product->name }}</h3>
                                                <span class="text-sm text-gray-400">{{ $item->product->category->name }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-white font-semibold">₱{{ number_format($item->product->price, 2) }}</td>
                                    <td class="px-6 py-4">
                                        <form action="{{ route('cart.update', $item) }}" method="POST" class="flex items-center space-x-2">
                                            @csrf
                                            @method('PUT')
                                            <input type="number" name="quantity" id="quantity" value="{{ $item->quantity }}"
                                                   min="1" max="{{ $item->product->stock_quantity }}"
                                                   class="w-20 rounded-lg border border-amber-500/30 bg-slate-900/50 text-white shadow-sm focus:border-amber-500 focus:ring-2 focus:ring-amber-500/30 transition">
                                            <button type="submit" class="px-3 py-2 bg-gradient-to-r from-amber-600 to-red-600 hover:from-amber-700 hover:to-red-700 text-white rounded-lg transition shadow-sm hover:shadow-md">
                                                <i class="fas fa-sync-alt"></i>
                                            </button>
                                        </form>
                                    </td>
                                    <td class="px-6 py-4 font-bold text-green-400 text-lg">
                                        ₱{{ number_format($item->product->price * $item->quantity, 2) }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <form action="{{ route('cart.remove', $item) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-3 py-2 text-white bg-gradient-to-r from-red-600 to-rose-600 hover:from-red-700 hover:to-rose-700 rounded-lg transition shadow-sm hover:shadow-md">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="px-6 py-6 bg-gradient-to-r from-slate-800 to-slate-900 border-t border-amber-500/20">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <p class="text-2xl font-bold text-white">Grand Total: <span class="bg-gradient-to-r from-amber-400 to-red-400 bg-clip-text text-transparent">₱{{ number_format($total, 2) }}</span></p>
                            <p class="text-sm text-gray-400 mt-1">Shipping and taxes calculated at checkout</p>
                        </div>
                    </div>
                    <div class="flex space-x-4">
                        <a href="{{ route('products.index') }}" class="px-6 py-3 border-2 border-amber-500 text-amber-300 hover:bg-amber-500/10 rounded-lg font-semibold transition-colors duration-150 flex items-center">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Continue Shopping
                        </a>
                        <a href="{{ route('checkout.index') }}" class="px-6 py-3 bg-gradient-to-r from-amber-600 to-red-600 hover:from-amber-700 hover:to-red-700 text-white rounded-lg font-semibold shadow-lg hover:shadow-xl transition-all duration-150 flex items-center">
                            <i class="fas fa-arrow-right mr-2"></i>
                            Proceed to Checkout
                        </a>
                    </div>
                </div>
            </div>
        @else
            <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-lg shadow-xl p-12 text-center border border-amber-500/20">
                <div class="mb-6">
                    <i class="fas fa-shopping-cart text-5xl text-amber-400/50"></i>
                </div>
                <h2 class="text-2xl font-bold text-white mb-2">Your cart is empty</h2>
                <p class="text-gray-400 mb-6">Looks like you haven't added any products to your cart yet.</p>
                <a href="{{ route('products.index') }}" class="px-6 py-3 bg-gradient-to-r from-amber-600 to-red-600 hover:from-amber-700 hover:to-red-700 text-white rounded-lg font-semibold shadow-lg hover:shadow-xl transition-all duration-150 inline-block">
                    🛍️ Browse Products
                </a>
            </div>
        @endif
    </div>
</div>
@endsection