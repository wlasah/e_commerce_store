@extends('layouts.admin')

@section('title', 'Categories')

@section('header', 'Categories')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <!-- Page Header -->
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-4xl font-bold bg-gradient-to-r from-amber-400 via-red-400 to-blue-400 bg-clip-text text-transparent">📂 Categories</h1>
                <p class="text-gray-400 mt-2">Manage your product categories</p>
            </div>
            <a href="{{ route('admin.categories.create') }}" class="px-4 py-2 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white rounded-lg font-medium flex items-center shadow-lg hover:shadow-xl transition">
                <i class="fas fa-plus mr-2"></i> Add New Category
            </a>
        </div>

        <!-- Flash Messages -->
        @if(session('success'))
            <div class="bg-gradient-to-r from-green-900/30 to-emerald-900/30 dark:from-green-900 dark:to-emerald-900 border-l-4 border-green-500 text-green-300 p-4 mb-6 rounded-lg shadow-sm">
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-3 text-green-400"></i>
                    <p>{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-gradient-to-r from-red-900/30 to-rose-900/30 dark:from-red-900 dark:to-rose-900 border-l-4 border-red-500 text-red-300 p-4 mb-6 rounded-lg shadow-sm">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle mr-3 text-red-400"></i>
                    <p>{{ session('error') }}</p>
                </div>
            </div>
        @endif

        <!-- Categories Table -->
        <div class="bg-gradient-to-br from-slate-800 to-slate-900 shadow-lg rounded-xl overflow-hidden border border-amber-500/20">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-amber-500/10">
                    <thead class="bg-gradient-to-r from-blue-900/40 to-red-900/40">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-amber-300 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-amber-300 uppercase tracking-wider">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-amber-300 uppercase tracking-wider">Subcategories</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-amber-300 uppercase tracking-wider">Products</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-amber-300 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-amber-500/10">
                        @forelse ($categories as $category)
                            <tr class="hover:bg-blue-900/20 transition">
                                <td class="px-6 py-4 text-sm text-slate-300">{{ $category->id }}</td>
                                <td class="px-6 py-4 font-medium text-slate-300">
                                    <a href="{{ route('admin.categories.show', $category) }}" class="hover:text-cyan-400 transition">
                                        {{ $category->name }}
                                    </a>
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $category->children_count > 0 ? 'bg-blue-900/40 text-blue-300 border border-blue-500/30' : 'bg-slate-700/40 text-slate-400 border border-slate-500/30' }}">
                                        {{ $category->children_count }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $category->total_products > 0 ? 'bg-green-900/40 text-green-300 border border-green-500/30' : 'bg-slate-700/40 text-slate-400 border border-slate-500/30' }}">
                                        {{ $category->total_products }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex space-x-3">
                                        <a href="{{ route('admin.categories.show', $category) }}" class="text-cyan-400 hover:text-cyan-300 transition" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.categories.edit', $category) }}" class="text-blue-400 hover:text-blue-300 transition" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this category? This action cannot be undone.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-400 hover:text-red-300 transition" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <p class="text-slate-400 text-base font-medium">No categories found</p>
                                    <p class="text-slate-500 text-sm mt-1">Create your first category to get started</p>
                                    <div class="mt-4">
                                        <a href="{{ route('admin.categories.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                            <i class="fas fa-plus mr-2"></i>Add New Category
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="px-6 py-4 border-t border-amber-500/20 bg-gradient-to-r from-blue-900/20 to-red-900/20">
                {{ $categories->links() }}
            </div>
        </div>
    </div>
@endsection