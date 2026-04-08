@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-950 via-blue-950 to-slate-950">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <!-- Filter Panel -->
        <div class="bg-gradient-to-br from-slate-800 to-blue-900 dark:from-slate-900 dark:to-blue-950 p-6 rounded-2xl shadow-2xl border border-amber-500/20 mb-10 backdrop-blur">
            <form action="{{ route('products.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4" id="filterForm">
                <!-- Category -->
                <div>
                    <label for="category" class="block text-sm font-bold text-amber-200 mb-2">📂 Category</label>
                    <select name="category" id="category" class="w-full px-4 py-2 rounded-lg bg-slate-700 border border-amber-400/50 text-white appearance-none cursor-pointer focus:outline-none focus:border-amber-400 focus:ring-2 focus:ring-amber-500/50" onchange="document.getElementById('filterForm').submit()">
                        <option value="">All Categories</option>
                        @foreach ($categories as $parentCategory)
                            <optgroup label="{{ $parentCategory->name }}">
                                @foreach ($parentCategory->children as $childCategory)
                                    <option value="{{ $childCategory->id }}" {{ request('category') == $childCategory->id ? 'selected' : '' }}>
                                        {{ $childCategory->name }}
                                    </option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                </div>

                <!-- Search -->
                <div>
                    <label for="search" class="block text-sm font-bold text-amber-200 mb-2">🔍 Search</label>
                    <input type="text" name="search" id="search" placeholder="Search products..." value="{{ request('search') }}"
                           class="w-full px-4 py-2 rounded-lg bg-slate-700 border border-amber-400/50 text-white placeholder-gray-400 focus:outline-none focus:border-amber-400 focus:ring-2 focus:ring-amber-500/50">
                </div>

                <!-- Sort -->
                <div>
                    <label for="sort" class="block text-sm font-bold text-amber-200 mb-2">📊 Sort By</label>
                    <select name="sort" id="sort" class="w-full px-4 py-2 rounded-lg bg-slate-700 border border-amber-400/50 text-white appearance-none cursor-pointer focus:outline-none focus:border-amber-400 focus:ring-2 focus:ring-amber-500/50" onchange="document.getElementById('filterForm').submit()">
                        <option value="">Default</option>
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest</option>
                        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                        <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Name: A-Z</option>
                    </select>
                </div>

                <!-- Filter Button -->
                <div class="flex items-end">
                    <button type="submit" class="w-full bg-gradient-to-r from-amber-500 to-red-600 hover:from-amber-600 hover:to-red-700 text-white font-bold py-2 px-4 rounded-lg shadow-lg hover:shadow-xl transform hover:scale-105 transition">
                        🔍 Search
                    </button>
                </div>
            </form>
        </div>

    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-4xl font-bold bg-gradient-to-r from-amber-400 via-red-400 to-blue-400 bg-clip-text text-transparent mb-2">🛍️ Products</h1>
            <p class="text-gray-300">Discover amazing items from our collection</p>
        </div>
    </div>

    <!-- Applied Filters Display -->
    @php
        $hasFilters = request()->has('search') || request()->has('category') || request()->has('sort');
        $selectedCategory = null;
        if (request()->has('category') && request()->category) {
            $selectedCategory = \App\Models\Category::find(request()->category);
        }
    @endphp
    @if($hasFilters)
        <div class="mb-6 bg-gradient-to-r from-blue-900/40 to-purple-900/40 border border-blue-500/30 rounded-lg p-4 flex items-center justify-between flex-wrap gap-4">
            <div class="flex items-center gap-2 flex-wrap">
                <span class="text-slate-300 font-semibold">✨ Active Filters:</span>
                @if(request()->has('category') && request()->category && $selectedCategory)
                    <span class="inline-flex items-center gap-1 px-3 py-1 bg-amber-500/20 border border-amber-500/50 text-amber-300 rounded-full text-sm font-medium hover:bg-amber-500/30 transition">
                        <i class="fas fa-folder"></i> {{ $selectedCategory->name }}
                        <a href="{{ route('products.index', array_merge(request()->query(), ['category' => null])) }}" class="ml-1 font-bold hover:text-amber-200 transition">✕</a>
                    </span>
                @endif
                @if(request()->has('search') && request()->search)
                    <span class="inline-flex items-center gap-1 px-3 py-1 bg-blue-500/20 border border-blue-500/50 text-blue-300 rounded-full text-sm font-medium hover:bg-blue-500/30 transition">
                        <i class="fas fa-search"></i> "{{ request()->search }}"
                        <a href="{{ route('products.index', array_merge(request()->query(), ['search' => null])) }}" class="ml-1 font-bold hover:text-blue-200 transition">✕</a>
                    </span>
                @endif
                @if(request()->has('sort') && request()->sort)
                    @php
                        $sortLabels = [
                            'newest' => 'Newest First',
                            'price_asc' => 'Price: Low to High',
                            'price_desc' => 'Price: High to Low',
                            'name_asc' => 'Name: A-Z'
                        ];
                    @endphp
                    <span class="inline-flex items-center gap-1 px-3 py-1 bg-purple-500/20 border border-purple-500/50 text-purple-300 rounded-full text-sm font-medium hover:bg-purple-500/30 transition">
                        <i class="fas fa-sort"></i> {{ $sortLabels[request()->sort] ?? request()->sort }}
                        <a href="{{ route('products.index', array_merge(request()->query(), ['sort' => null])) }}" class="ml-1 font-bold hover:text-purple-200 transition">✕</a>
                    </span>
                @endif
            </div>
            <a href="{{ route('products.index') }}" class="text-red-400 hover:text-red-300 font-semibold text-sm flex items-center gap-2 px-3 py-1 bg-red-500/20 border border-red-500/30 rounded-full hover:bg-red-500/30 transition">
                <i class="fas fa-times-circle"></i> Clear All
            </a>
        </div>
    @endif

    <!-- Product Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @forelse ($products as $product)
            <div class="group bg-gradient-to-br from-slate-800 to-slate-900 rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 overflow-hidden border border-amber-500/20 hover:border-amber-500/60">
                <div class="h-48 bg-gradient-to-br from-purple-900 to-slate-900 relative overflow-hidden">
                    @if ($product->image_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($product->image_path))
                        <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}"
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300" loading="lazy">
                    @else
                        <div class="flex items-center justify-center h-full bg-gradient-to-br from-purple-600 to-pink-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-white/50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    @endif
                    @if($product->stock_quantity > 0)
                        <div class="absolute top-2 right-2 bg-gradient-to-r from-green-500 to-emerald-600 text-white px-3 py-1 rounded-full text-xs font-bold">In Stock</div>
                    @else
                        <div class="absolute top-2 right-2 bg-gradient-to-r from-red-500 to-rose-600 text-white px-3 py-1 rounded-full text-xs font-bold">Out of Stock</div>
                    @endif
                </div>

                <div class="p-5">
                    <h2 class="text-lg font-bold text-white truncate group-hover:text-purple-300 transition">{{ $product->name }}</h2>
                    <p class="bg-gradient-to-r from-amber-400 to-red-400 bg-clip-text text-transparent font-bold text-xl mt-2">₱{{ number_format($product->price, 2) }}</p>
                    <p class="text-sm text-gray-300 mt-3 line-clamp-2">{{ $product->description }}</p>

                    <div class="mt-5 flex justify-between items-center text-sm">
                        <span class="{{ $product->stock_quantity > 0 ? 'text-green-400 font-semibold' : 'text-red-400 font-semibold' }}">
                            {{ $product->stock_quantity > 0 ? 'In Stock: ' . $product->stock_quantity : 'Out of Stock' }}
                        </span>
                        <div class="flex gap-3">
                            <a href="{{ route('products.show', $product) }}" class="text-cyan-400 hover:text-cyan-300 font-semibold transition">
                                View
                            </a>
                            @if (auth()->check() && auth()->user()->is_admin)
                                <a href="{{ route('admin.products.edit', $product) }}" class="text-yellow-400 hover:text-yellow-300 font-semibold transition">
                                    Edit
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full py-16 text-center">
                <div class="inline-block">
                    <i class="fas fa-search text-6xl text-slate-600 mb-4"></i>
                    <h3 class="text-2xl font-bold text-slate-400 mb-2">No Products Found</h3>
                    @if($hasFilters)
                        <p class="text-slate-500 mb-6">Try adjusting your filters or search terms</p>
                        <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 px-6 py-2 bg-gradient-to-r from-amber-600 to-red-600 hover:from-amber-700 hover:to-red-700 text-white font-bold rounded-lg transition">
                            <i class="fas fa-times"></i> Clear Filters
                        </a>
                    @else
                        <p class="text-slate-500">No products available at the moment</p>
                    @endif
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-10">
        {{ $products->withQueryString()->links() }}
    </div>
</div>
@endsection
