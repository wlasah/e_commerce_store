@extends('layouts.app')

@section('title', 'User Profile')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-950 via-blue-950 to-slate-950 py-10">
    <div class="container mx-auto px-4 max-w-3xl">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold bg-gradient-to-r from-amber-400 via-red-400 to-blue-400 bg-clip-text text-transparent">👤 User Profile</h1>
            <p class="text-gray-400 mt-2">Manage your account settings and preferences</p>
        </div>

        <!-- Success Messages -->
        @if (session('status') === 'profile-updated')
            <div class="bg-gradient-to-r from-green-900/30 to-emerald-900/30 border-l-4 border-green-500 text-green-300 px-6 py-4 rounded-lg mb-6 flex items-center">
                <i class="fas fa-check-circle mr-3"></i>
                Profile updated successfully!
            </div>
        @endif

        @if (session('status') === 'password-updated')
            <div class="bg-gradient-to-r from-green-900/30 to-emerald-900/30 border-l-4 border-green-500 text-green-300 px-6 py-4 rounded-lg mb-6 flex items-center">
                <i class="fas fa-check-circle mr-3"></i>
                Password updated successfully!
            </div>
        @endif

        <!-- Avatar & Profile Information Section -->
        <div class="bg-gradient-to-br from-slate-800 to-slate-900 shadow-xl rounded-xl p-8 mb-6 border border-amber-500/20">
            <h2 class="text-2xl font-bold text-amber-300 mb-6 flex items-center">
                <i class="fas fa-user-circle mr-3"></i> Avatar & Profile
            </h2>

            <form action="{{ route('profile.update') }}" method="POST" class="space-y-6" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <!-- Avatar Section -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pb-6 border-b border-amber-500/20">
                    <div class="md:col-span-1 flex justify-center items-start">
                        <div class="text-center">
                            <div class="w-32 h-32 mx-auto mb-4 rounded-full overflow-hidden ring-4 ring-amber-500/30 flex items-center justify-center bg-gradient-to-br from-amber-500/20 to-red-500/20">
                                @if($user->avatar && \Illuminate\Support\Facades\Storage::disk('public')->exists($user->avatar))
                                    <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-amber-500 to-red-600 flex items-center justify-center text-white font-bold text-4xl">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                @endif
                            </div>
                            <p class="text-xs text-gray-400">Current Avatar</p>
                        </div>
                    </div>

                    <div class="md:col-span-2">
                        <label for="avatar" class="block text-sm font-semibold text-amber-300 mb-3">📷 Upload New Avatar</label>
                        
                        <!-- Drop Zone -->
                        <div id="userDropZone" class="relative border-2 border-dashed border-amber-500/30 rounded-lg p-6 hover:border-amber-500/60 transition bg-slate-900/50 cursor-pointer">
                            <input type="file" id="avatar" name="avatar" accept="image/*" class="hidden" onchange="handleUserAvatarSelect(event)">
                            <label for="avatar" class="cursor-pointer flex flex-col items-center justify-center pointer-events-none">
                                <i class="fas fa-cloud-upload-alt text-amber-400 text-3xl mb-2"></i>
                                <span class="text-amber-300 font-medium">Click to upload or drag & drop</span>
                                <span class="text-xs text-gray-400 mt-1">PNG, JPG, GIF (Max 5MB, 100x100 to 2000x2000px)</span>
                            </label>
                        </div>

                        <!-- Image Preview -->
                        <div id="userPreviewContainer" class="hidden mt-4">
                            <img id="userPreviewImage" src="" alt="Preview" class="w-32 h-32 rounded-lg ring-4 ring-green-500/50 object-cover mx-auto animate-pulse">
                            <p class="text-center text-green-400 text-sm mt-2">✓ Preview - Click save to confirm</p>
                        </div>

                        @error('avatar')
                            <p class="text-sm text-red-400 mt-2 flex items-center">
                                <i class="fas fa-exclamation-circle mr-2"></i> {{ $message }}
                            </p>
                        @enderror
                        <p class="text-xs text-gray-400 mt-2">💡 Tip: Use a clear photo for better appearance</p>
                    </div>
                </div>

                <!-- Name & Email -->
                <div class="space-y-5">
                    <div>
                        <label for="name" class="block text-sm font-semibold text-amber-300 mb-2">👤 Full Name</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}"
                            class="w-full p-3 border border-amber-500/30 bg-slate-900/50 text-white rounded-lg focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 transition @error('name') border-red-500 @enderror" required>
                        @error('name')
                            <p class="text-sm text-red-400 mt-1 flex items-center">
                                <i class="fas fa-exclamation-circle mr-2"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-semibold text-amber-300 mb-2">✉️ Email Address</label>
                        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}"
                            class="w-full p-3 border border-amber-500/30 bg-slate-900/50 text-white rounded-lg focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 transition @error('email') border-red-500 @enderror" required>
                        @error('email')
                            <p class="text-sm text-red-400 mt-1 flex items-center">
                                <i class="fas fa-exclamation-circle mr-2"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                <div class="flex justify-end pt-4">
                    <button type="submit" class="px-6 py-3 bg-gradient-to-r from-amber-600 to-red-600 hover:from-amber-700 hover:to-red-700 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transition flex items-center">
                        <i class="fas fa-save mr-2"></i> Save Profile Changes
                    </button>
                </div>
            </form>
        </div>

    <!-- Update Password Section -->
    <div class="bg-gradient-to-br from-slate-800 to-slate-900 shadow-xl rounded-xl p-8 mb-6 border border-blue-500/20">
        <h2 class="text-2xl font-bold text-blue-300 mb-6 flex items-center">
            <i class="fas fa-lock mr-3"></i> Security Settings
        </h2>

        <form action="{{ route('password.update') }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label for="current_password" class="block text-sm font-semibold text-blue-300 mb-2">🔐 Current Password</label>
                <input type="password" id="current_password" name="current_password"
                    class="w-full p-3 border border-blue-500/30 bg-slate-900/50 text-white rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition @error('current_password') border-red-500 @enderror" required>
                @error('current_password')
                    <p class="text-sm text-red-400 mt-1 flex items-center">
                        <i class="fas fa-exclamation-circle mr-2"></i> {{ $message }}
                    </p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-semibold text-blue-300 mb-2">🔑 New Password</label>
                <input type="password" id="password" name="password"
                    class="w-full p-3 border border-blue-500/30 bg-slate-900/50 text-white rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition @error('password') border-red-500 @enderror" required>
                @error('password')
                    <p class="text-sm text-red-400 mt-1 flex items-center">
                        <i class="fas fa-exclamation-circle mr-2"></i> {{ $message }}
                    </p>
                @enderror
                <p class="text-xs text-gray-400 mt-2">💡 Use at least 8 characters with uppercase, lowercase, and numbers</p>
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-semibold text-blue-300 mb-2">✔️ Confirm New Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation"
                    class="w-full p-3 border border-blue-500/30 bg-slate-900/50 text-white rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition" required>
            </div>

            <div class="flex justify-end pt-4">
                <button type="submit" class="px-6 py-3 bg-gradient-to-r from-blue-600 to-cyan-600 hover:from-blue-700 hover:to-cyan-700 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transition flex items-center">
                    <i class="fas fa-refresh mr-2"></i> Update Password
                </button>
            </div>
        </form>
    </div>

    <!-- Delete Account Section -->
    <div class="bg-gradient-to-br from-red-900/20 to-rose-900/20 shadow-xl rounded-xl p-8 border border-red-500/20">
        <h2 class="text-2xl font-bold text-red-400 mb-6 flex items-center">
            <i class="fas fa-exclamation-triangle mr-3"></i> Danger Zone
        </h2>

        <form action="{{ route('profile.destroy') }}" method="POST" class="space-y-5">
            @csrf
            @method('DELETE')

            <div class="bg-red-900/30 border-l-4 border-red-500 p-4 rounded">
                <p class="text-sm text-red-200">
                    ⚠️ <strong>Warning:</strong> Once your account is deleted, all resources and data will be permanently deleted and cannot be recovered.
                </p>
            </div>

            <div>
                <label for="delete_password" class="block text-sm font-semibold text-red-300 mb-2">🔒 Enter Password to Confirm Deletion</label>
                <input type="password" id="delete_password" name="password"
                    class="w-full p-3 border border-red-500/30 bg-slate-900/50 text-white rounded-lg focus:border-red-500 focus:ring-2 focus:ring-red-500/20 transition @error('password') border-red-500 @enderror" required placeholder="Type your password to confirm">
                @error('password')
                    <p class="text-sm text-red-400 mt-1 flex items-center">
                        <i class="fas fa-exclamation-circle mr-2"></i> {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="flex justify-end pt-4">
                <button type="submit" onclick="return confirm('⚠️ This action cannot be undone! Are you absolutely sure you want to delete your account?')" class="px-6 py-3 bg-gradient-to-r from-red-600 to-rose-600 hover:from-red-700 hover:to-rose-700 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transition flex items-center">
                    <i class="fas fa-trash mr-2"></i> Delete Account Permanently
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Avatar Upload Script -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const fileInput = document.getElementById('avatar');
        const dropZone = document.getElementById('userDropZone');
        const previewContainer = document.getElementById('userPreviewContainer');
        const previewImage = document.getElementById('userPreviewImage');

        if (!fileInput || !dropZone) return;

        // Click to upload
        dropZone.addEventListener('click', (e) => {
            if (e.target.closest('button') === null) {
                fileInput.click();
            }
        });

        // Drag and drop
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        ['dragenter', 'dragover'].forEach(eventName => {
            dropZone.addEventListener(eventName, () => {
                dropZone.classList.add('border-amber-500', 'bg-amber-500/20');
                dropZone.classList.remove('border-amber-500/30');
            });
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, () => {
                dropZone.classList.remove('border-amber-500', 'bg-amber-500/20');
                dropZone.classList.add('border-amber-500/30');
            });
        });

        dropZone.addEventListener('drop', (e) => {
            const dt = e.dataTransfer;
            const files = dt.files;
            fileInput.files = files;
            fileInput.dispatchEvent(new Event('change', { bubbles: true }));
        });
    });

    function handleUserAvatarSelect(e) {
        const file = e.target.files[0];
        if (!file) return;

        // Validate file type
        if (!['image/jpeg', 'image/png', 'image/gif'].includes(file.type)) {
            alert('Please select a valid image file (PNG, JPG, GIF)');
            document.getElementById('avatar').value = '';
            document.getElementById('userPreviewContainer').classList.add('hidden');
            return;
        }

        // Validate file size (5MB)
        if (file.size > 5 * 1024 * 1024) {
            alert('File size must be less than 5MB');
            document.getElementById('avatar').value = '';
            document.getElementById('userPreviewContainer').classList.add('hidden');
            return;
        }

        // Read and show preview
        const reader = new FileReader();
        reader.onload = function(event) {
            const img = new Image();
            img.onload = function() {
                // Validate dimensions
                if (img.width < 100 || img.height < 100 || img.width > 2000 || img.height > 2000) {
                    alert('Image dimensions must be between 100x100 and 2000x2000 pixels');
                    document.getElementById('avatar').value = '';
                    document.getElementById('userPreviewContainer').classList.add('hidden');
                    return;
                }

                document.getElementById('userPreviewImage').src = event.target.result;
                document.getElementById('userPreviewContainer').classList.remove('hidden');
            };
            img.src = event.target.result;
        };
        reader.readAsDataURL(file);
    }
</script>
@endsection
