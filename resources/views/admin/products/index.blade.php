@extends('layouts.admin')

@section('title', 'Products')

@section('header', 'Products')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <!-- Page Header -->
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-4xl font-bold bg-gradient-to-r from-amber-400 via-red-400 to-blue-400 bg-clip-text text-transparent">📦 Products</h1>
                <p class="text-gray-400 mt-2">Manage your product catalog</p>
            </div>
            <a href="{{ route('admin.products.create') }}" class="px-4 py-2 bg-gradient-to-r from-blue-600 to-cyan-600 hover:from-blue-700 hover:to-cyan-700 text-white rounded-lg font-medium flex items-center shadow-lg hover:shadow-xl transition">
                <i class="fas fa-plus mr-2"></i> Add New Product
            </a>
        </div>

        <!-- Products Table -->
        <div class="bg-gradient-to-br from-slate-800 to-slate-900 shadow-lg rounded-xl overflow-hidden border border-amber-500/20">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-amber-500/10">
                    <thead class="bg-gradient-to-r from-blue-900/40 to-red-900/40">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-amber-300 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-amber-300 uppercase tracking-wider">Image</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-amber-300 uppercase tracking-wider">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-amber-300 uppercase tracking-wider">Category</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-amber-300 uppercase tracking-wider">Price</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-amber-300 uppercase tracking-wider">Stock</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-amber-300 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-amber-500/10">
                        @forelse ($products as $product)
                            <tr class="hover:bg-blue-900/20 transition">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-slate-300">{{ $product->id }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($product->image_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($product->image_path))
                                        <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" class="h-10 w-10 object-cover rounded">
                                    @else
                                        <div class="h-10 w-10 bg-gradient-to-br from-indigo-100 to-indigo-50 rounded flex items-center justify-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-slate-300">{{ $product->name }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-slate-400">{{ $product->category->name }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-semibold text-green-400">₱{{ number_format($product->price, 2) }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $product->stock_quantity > 0 ? 'bg-green-900/40 text-green-300 border border-green-500/30' : 'bg-red-900/40 text-red-300 border border-red-500/30' }}">
                                        {{ $product->stock_quantity }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-3">
                                        <a href="{{ route('admin.products.edit', $product) }}" class="text-cyan-400 hover:text-cyan-300 flex items-center">
                                            <i class="fas fa-edit mr-1"></i>Edit
                                        </a>
                                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-400 hover:text-red-300 flex items-center" onclick="return confirm('Are you sure you want to delete this product?')">
                                                <i class="fas fa-trash mr-1"></i>Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-8 whitespace-nowrap text-sm text-slate-400 text-center">
                                    No products found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-amber-500/20 bg-gradient-to-r from-blue-900/20 to-red-900/20">
                {{ $products->links() }}
            </div>
        </div>
    </div>
@endsection
