
@extends('layouts.admin')

@section('title', 'Add User')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <!-- Page Header -->
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-4xl font-bold bg-gradient-to-r from-amber-400 via-red-400 to-blue-400 bg-clip-text text-transparent">➕ Add New User</h1>
            <p class="text-gray-400 mt-2">Create a new user account</p>
        </div>
        <a href="{{ route('admin.users.index') }}" class="bg-slate-700 hover:bg-slate-600 text-white font-bold py-3 px-6 rounded-lg transition-all duration-200 flex items-center gap-2">
            <i class="fas fa-arrow-left"></i> Back to Users
        </a>
    </div>

    <!-- Create User Form -->
    <div class="bg-gradient-to-br from-slate-800 to-slate-900 shadow-xl rounded-xl overflow-hidden border border-amber-500/20">
        <div class="px-6 py-4 border-b border-amber-500/20 bg-gradient-to-r from-blue-900/40 to-red-900/40">
            <h2 class="text-lg font-semibold text-amber-300 flex items-center gap-2">
                <i class="fas fa-user-plus"></i> Create New User
            </h2>
        </div>

        <form action="{{ route('admin.users.store') }}" method="POST" class="p-8 space-y-6">
            @csrf

            <!-- Name Field -->
            <div>
                <label for="name" class="block text-amber-300 font-semibold mb-2">👤 Full Name</label>
                <input type="text" name="name" id="name" 
                    class="w-full bg-slate-900 border border-amber-500/20 text-white rounded-lg px-4 py-3 focus:border-amber-500 focus:ring-1 focus:ring-amber-500/50 outline-none transition @error('name') border-red-500 @enderror" 
                    value="{{ old('name') }}" 
                    placeholder="Enter user name" 
                    required>
                @error('name')
                    <p class="text-red-400 text-sm mt-1 flex items-center">
                        <i class="fas fa-exclamation-circle mr-2"></i> {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Email Field -->
            <div>
                <label for="email" class="block text-amber-300 font-semibold mb-2">✉️ Email Address</label>
                <input type="email" name="email" id="email" 
                    class="w-full bg-slate-900 border border-amber-500/20 text-white rounded-lg px-4 py-3 focus:border-amber-500 focus:ring-1 focus:ring-amber-500/50 outline-none transition @error('email') border-red-500 @enderror" 
                    value="{{ old('email') }}" 
                    placeholder="user@example.com" 
                    required>
                @error('email')
                    <p class="text-red-400 text-sm mt-1 flex items-center">
                        <i class="fas fa-exclamation-circle mr-2"></i> {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Password Field -->
            <div>
                <label for="password" class="block text-amber-300 font-semibold mb-2">🔐 Password</label>
                <input type="password" name="password" id="password" 
                    class="w-full bg-slate-900 border border-amber-500/20 text-white rounded-lg px-4 py-3 focus:border-amber-500 focus:ring-1 focus:ring-amber-500/50 outline-none transition @error('password') border-red-500 @enderror" 
                    placeholder="••••••••" 
                    required>
                <p class="text-slate-400 text-sm mt-1">💡 Use at least 8 characters with uppercase, lowercase, and numbers</p>
                @error('password')
                    <p class="text-red-400 text-sm mt-1 flex items-center">
                        <i class="fas fa-exclamation-circle mr-2"></i> {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Confirm Password Field -->
            <div>
                <label for="password_confirmation" class="block text-amber-300 font-semibold mb-2">✔️ Confirm Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" 
                    class="w-full bg-slate-900 border border-amber-500/20 text-white rounded-lg px-4 py-3 focus:border-amber-500 focus:ring-1 focus:ring-amber-500/50 outline-none transition" 
                    placeholder="••••••••" 
                    required>
            </div>

            <!-- Role Field -->
            <div>
                <label for="is_admin" class="block text-amber-300 font-semibold mb-2">👑 Role</label>
                <select name="is_admin" id="is_admin" 
                    class="w-full bg-slate-900 border border-amber-500/20 text-white rounded-lg px-4 py-3 focus:border-amber-500 focus:ring-1 focus:ring-amber-500/50 outline-none transition @error('is_admin') border-red-500 @enderror" 
                    required>
                    <option value="0" class="bg-slate-900">👤 Regular User</option>
                    <option value="1" class="bg-slate-900">👑 Administrator</option>
                </select>
                @error('is_admin')
                    <p class="text-red-400 text-sm mt-1 flex items-center">
                        <i class="fas fa-exclamation-circle mr-2"></i> {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Actions -->
            <div class="flex gap-4 pt-6 border-t border-amber-500/20">
                <button type="submit" class="flex-1 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-bold py-3 rounded-lg transition-all duration-200 flex items-center justify-center gap-2 shadow-lg">
                    <i class="fas fa-save"></i> Create User
                </button>
                <a href="{{ route('admin.users.index') }}" class="flex-1 bg-slate-700 hover:bg-slate-600 text-white font-bold py-3 rounded-lg transition-all duration-200 flex items-center justify-center gap-2">
                    <i class="fas fa-times"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection