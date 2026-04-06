@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-950 via-blue-950 to-slate-950 py-10">
    <div class="container mx-auto px-4 max-w-6xl">
        <div class="mb-8">
            <h1 class="text-4xl font-bold bg-gradient-to-r from-amber-400 via-red-400 to-blue-400 bg-clip-text text-transparent">🛒 Checkout</h1>
            <p class="text-gray-400 mt-2">Review your order and complete payment</p>
        </div>
        
        @if(session('error'))
            <div class="mb-4 bg-gradient-to-r from-red-900/30 to-red-800/30 border-l-4 border-red-500 text-red-300 px-6 py-4 rounded-lg flex items-center">
                <i class="fas fa-exclamation-circle mr-3 text-red-500"></i>
                {{ session('error') }}
            </div>
        @endif
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Order Summary -->
        <div class="lg:col-span-2">
            <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-xl shadow-xl overflow-hidden border border-amber-500/20 mb-6">
                <div class="px-6 py-4 border-b border-amber-500/20 bg-gradient-to-r from-blue-900/40 to-red-900/40">
                    <h2 class="text-lg font-semibold text-amber-300 flex items-center gap-2">
                        <i class="fas fa-box"></i> Order Summary
                    </h2>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-gradient-to-r from-blue-900/40 to-red-900/40 border-b border-amber-500/10">
                            <tr>
                                <th class="px-4 py-3 text-xs font-semibold text-amber-300 uppercase tracking-wider">Product</th>
                                <th class="px-4 py-3 text-xs font-semibold text-amber-300 uppercase tracking-wider text-center">Qty</th>
                                <th class="px-4 py-3 text-xs font-semibold text-amber-300 uppercase tracking-wider text-right">Price</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-amber-500/10">
                            @foreach($cartItems as $item)
                                <tr class="hover:bg-blue-900/20 transition">
                                    <td class="px-4 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-16 h-16 rounded-lg overflow-hidden bg-slate-700 flex-shrink-0">
                                                @if($item->product->image_path)
                                                    <img src="{{ asset('storage/' . $item->product->image_path) }}" 
                                                         alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                                                @else
                                                    <div class="w-full h-full flex items-center justify-center">
                                                        <i class="fas fa-image text-slate-500 text-2xl"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <div>
                                                <h3 class="font-medium text-slate-200 text-sm">{{ $item->product->name }}</h3>
                                                <p class="text-slate-400 text-xs mt-1">SKU: {{ $item->product->id }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 text-center text-slate-300">{{ $item->quantity }}</td>
                                    <td class="px-4 py-4 text-right text-green-400 font-semibold">₱{{ number_format($item->product->price * $item->quantity, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-gradient-to-r from-blue-900/40 to-red-900/40 border-t border-amber-500/10">
                            <tr>
                                <td class="px-4 py-3 font-bold text-amber-300" colspan="2">Total Amount</td>
                                <td class="px-4 py-3 text-right font-bold text-yellow-400 text-lg">₱{{ number_format($total, 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        
        <!-- Checkout Form -->
        <div class="lg:col-span-1">
            <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-xl shadow-xl overflow-hidden border border-amber-500/20 sticky top-4">
                <div class="px-6 py-4 border-b border-amber-500/20 bg-gradient-to-r from-blue-900/40 to-red-900/40">
                    <h2 class="text-lg font-semibold text-amber-300 flex items-center gap-2">
                        <i class="fas fa-truck"></i> Shipping & Payment
                    </h2>
                </div>
                
                <form action="{{ route('checkout.process') }}" method="POST" class="p-6 space-y-5">
                    @csrf
                    
                    <!-- Shipping Address -->
                    <div>
                        <label for="shipping_address" class="block text-sm font-semibold text-amber-300 mb-2">📍 Shipping Address</label>
                        <textarea name="shipping_address" id="shipping_address" rows="4" 
                                  class="w-full bg-slate-900 border border-amber-500/20 text-white rounded-lg px-4 py-3 focus:border-amber-500 focus:ring-1 focus:ring-amber-500/50 outline-none transition resize-none @error('shipping_address') border-red-500 @enderror" 
                                  placeholder="Enter your full shipping address" 
                                  required>{{ old('shipping_address') }}</textarea>
                        @error('shipping_address')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Payment Method -->
                    <div>
                        <label class="block text-sm font-semibold text-amber-300 mb-3">💳 Payment Method</label>
                        <div class="space-y-3">
                            <div class="flex items-center p-3 border border-amber-500/20 rounded-lg hover:bg-blue-900/20 cursor-pointer transition">
                                <input type="radio" id="credit_card" name="payment_method" value="credit_card" 
                                       class="w-4 h-4 text-amber-500 bg-slate-900 border-amber-500/30 focus:ring-amber-500" 
                                       checked>
                                <label for="credit_card" class="ml-3 text-sm text-slate-300 cursor-pointer flex-1">
                                    <i class="fas fa-credit-card mr-2 text-amber-400"></i> Credit Card
                                </label>
                            </div>
                            <div class="flex items-center p-3 border border-amber-500/20 rounded-lg hover:bg-blue-900/20 cursor-pointer transition">
                                <input type="radio" id="paypal" name="payment_method" value="paypal" 
                                       class="w-4 h-4 text-amber-500 bg-slate-900 border-amber-500/30 focus:ring-amber-500">
                                <label for="paypal" class="ml-3 text-sm text-slate-300 cursor-pointer flex-1">
                                    <i class="fab fa-paypal mr-2 text-blue-400"></i> PayPal
                                </label>
                            </div>
                            <div class="flex items-center p-3 border border-amber-500/20 rounded-lg hover:bg-blue-900/20 cursor-pointer transition">
                                <input type="radio" id="cash_on_delivery" name="payment_method" value="cash_on_delivery" 
                                       class="w-4 h-4 text-amber-500 bg-slate-900 border-amber-500/30 focus:ring-amber-500">
                                <label for="cash_on_delivery" class="ml-3 text-sm text-slate-300 cursor-pointer flex-1">
                                    <i class="fas fa-money-bill mr-2 text-green-400"></i> Cash on Delivery
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Actions -->
                    <div class="flex flex-col gap-3 pt-4 border-t border-amber-500/20">
                        <button type="submit" class="w-full bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-bold py-3 rounded-lg transition-all duration-200 flex items-center justify-center gap-2 shadow-lg">
                            <i class="fas fa-check-circle"></i> Place Order
                        </button>
                        <a href="{{ route('cart.index') }}" class="w-full text-center bg-slate-700 hover:bg-slate-600 text-white font-bold py-3 rounded-lg transition-all duration-200 flex items-center justify-center gap-2">
                            <i class="fas fa-arrow-left"></i> Return to Cart
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection