@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-950 via-blue-950 to-slate-950">
    <div class="container mx-auto px-4 py-8">
        <!-- Breadcrumb -->
        <nav class="mb-6">
            <ol class="flex text-sm">
                <li class="mr-2">
                    <a href="{{ route('shop.index') }}" class="text-amber-400 hover:text-amber-300 transition">Home</a>
                </li>
                <li class="mr-2 text-gray-500">/</li>
                <li class="mr-2">
                    <a href="{{ route('products.index') }}" class="text-amber-400 hover:text-amber-300 transition">Products</a>
                </li>
                <li class="mr-2 text-gray-500">/</li>
                <li class="text-gray-400">{{ $product->name }}</li>
            </ol>
        </nav>

        <!-- Product Detail -->
        <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-2xl shadow-2xl overflow-hidden border border-amber-500/20">
            <div class="md:flex">
                <!-- Product Image -->
                <div class="md:w-1/2 p-8">
                    @if ($product->image_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($product->image_path))
                        <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" 
                             class="w-full h-auto object-cover rounded-lg shadow-lg" loading="lazy">
                    @else
                        <div class="flex flex-col items-center justify-center h-96 bg-gradient-to-br from-amber-500/30 to-red-500/30 rounded-lg text-gray-400 border border-amber-500/20">
                            <i class="fas fa-image text-4xl mb-3 text-amber-400"></i>
                            <span>No Image Available</span>
                        </div>
                    @endif
                </div>
                
                <!-- Product Info -->
                <div class="md:w-1/2 p-8">
                    <div class="mb-6">
                        <h1 class="text-4xl font-bold text-white mb-3">{{ $product->name }}</h1>
                        <div class="flex items-center mb-4">
                            <span class="mr-2 text-sm text-gray-400">📂 Category:</span>
                            <span class="bg-gradient-to-r from-amber-500/30 to-red-500/30 text-amber-300 text-sm font-medium px-3 py-1 rounded-full border border-amber-500/30">
                                {{ $product->category->name }}
                            </span>
                        </div>
                        <p class="text-4xl font-bold bg-gradient-to-r from-amber-400 to-red-400 bg-clip-text text-transparent">₱{{ number_format($product->price, 2) }}</p>
                    </div>
                    
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-amber-300 mb-2">📝 Description</h3>
                        <p class="text-gray-300">{{ $product->description }}</p>
                    </div>
                    
                    <div class="mb-6">
                        <div class="flex items-center">
                            <span class="mr-2 text-sm {{ $product->stock_quantity > 0 ? 'text-green-400' : 'text-red-400' }}">
                                <span class="font-medium">{{ $product->stock_quantity > 0 ? '✅ In Stock' : '❌ Out of Stock' }}</span>
                            </span>
                            @if ($product->stock_quantity > 0)
                                <span class="text-sm text-gray-400">({{ $product->stock_quantity }} available)</span>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Show Add to Cart only for non-admin users -->
                    @if ($product->stock_quantity > 0)
                        @if (auth()->check() && !auth()->user()->is_admin)
                            <form action="{{ route('cart.add', $product) }}" method="POST" class="mb-6">
                                @csrf
                                <div class="flex items-center space-x-4 mb-4">
                                    <label for="quantity" class="text-sm font-medium text-gray-300">Quantity:</label>
                                    <input type="number" name="quantity" id="quantity" value="1" min="1" max="{{ $product->stock_quantity }}"
                                           class="w-20 border border-amber-500/30 bg-slate-900/50 text-white rounded-lg shadow-sm focus:border-amber-500 focus:ring focus:ring-amber-500/30">
                                </div>
                                
                                <button type="submit" class="w-full bg-gradient-to-r from-amber-600 to-red-600 hover:from-amber-700 hover:to-red-700 text-white font-bold py-3 px-4 rounded-lg transition-all duration-150 shadow-lg hover:shadow-xl">
                                    🛒 Add to Cart
                                </button>
                            </form>
                        @elseif (!auth()->check())
                            <div class="mb-6">
                                <a href="{{ route('auth.options') }}" class="w-full bg-gradient-to-r from-amber-600 to-red-600 hover:from-amber-700 hover:to-red-700 text-white font-bold py-3 px-4 rounded-lg transition-all duration-150 text-center block shadow-lg hover:shadow-xl">
                                    🔐 Register or Log In to Add to Cart
                                </a>
                            </div>
                        @endif
                    @else
                        <div class="mb-6">
                            <button disabled class="w-full bg-gray-600 text-gray-300 font-bold py-3 px-4 rounded-lg cursor-not-allowed">
                                Out of Stock
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Related Products -->
        @if ($relatedProducts->count() > 0)
        <div class="mt-16">
            <h2 class="text-3xl font-bold bg-gradient-to-r from-amber-400 via-red-400 to-blue-400 bg-clip-text text-transparent mb-8">🔗 Related Products</h2>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach ($relatedProducts as $relatedProduct)
                    <div class="group bg-gradient-to-br from-slate-800 to-slate-900 rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 overflow-hidden border border-amber-500/20 hover:border-amber-500/60">
                            <div class="h-48 bg-gradient-to-br from-blue-900 to-slate-900 relative overflow-hidden">
                            @if ($relatedProduct->image_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($relatedProduct->image_path))
                                <img src="{{ asset('storage/' . $relatedProduct->image_path) }}" alt="{{ $relatedProduct->name }}" 
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                            @else
                                    <div class="flex items-center justify-center h-full bg-gradient-to-br from-amber-600 to-red-600">
                                    <i class="fas fa-image text-2xl text-white/50"></i>
                                </div>
                            @endif
                        </div>
                        
                        <div class="p-4">
                            <h3 class="text-lg font-bold mb-2 text-white truncate group-hover:text-amber-300 transition">{{ $relatedProduct->name }}</h3>
                            <p class="bg-gradient-to-r from-amber-400 to-red-400 bg-clip-text text-transparent font-bold">₱{{ number_format($relatedProduct->price, 2) }}</p>
                            
                            <div class="mt-4 flex justify-between items-center">
                                <span class="text-sm {{ $relatedProduct->stock_quantity > 0 ? 'text-green-400 font-semibold' : 'text-red-400 font-semibold' }}">
                                    {{ $relatedProduct->stock_quantity > 0 ? 'In Stock' : 'Out of Stock' }}
                                </span>
                                
                                <a href="{{ route('products.show', $relatedProduct) }}" 
                                   class="text-cyan-400 hover:text-cyan-300 font-semibold text-sm transition">
                                    View
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>
@endsection