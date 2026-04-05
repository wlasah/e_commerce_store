@extends('layouts.admin')

@section('title', 'Admin Profile')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-950 via-blue-950 to-slate-950 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl mx-auto">
        <!-- Success Message -->
        @if (session('status') === 'profile-updated')
            <div class="mb-6 bg-gradient-to-r from-green-500 to-emerald-600 text-white rounded-lg p-4 flex items-center gap-3 shadow-lg">
                <i class="fas fa-check-circle text-2xl"></i>
                <div>
                    <p class="font-bold">Success!</p>
                    <p class="text-sm">Profile updated successfully.</p>
                </div>
            </div>
        @endif

        @if (session('status') === 'password-updated')
            <div class="mb-6 bg-gradient-to-r from-blue-500 to-cyan-600 text-white rounded-lg p-4 flex items-center gap-3 shadow-lg">
                <i class="fas fa-check-circle text-2xl"></i>
                <div>
                    <p class="font-bold">Success!</p>
                    <p class="text-sm">Password updated successfully.</p>
                </div>
            </div>
        @endif

        <!-- Avatar & Profile Section -->
        <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-lg border border-amber-500/20 overflow-hidden shadow-2xl mb-6">
            <div class="p-8">
                <!-- Avatar Upload -->
                <div class="mb-8 text-center">
                    <h2 class="text-amber-500 text-2xl font-bold mb-6 flex items-center justify-center gap-2">
                        <i class="fas fa-user-circle"></i> Avatar & Profile
                    </h2>
                    
                    <form id="avatarForm" method="post" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data" class="inline-block">
                        @csrf
                        @method('patch')
                        
                        <!-- Avatar Preview -->
                        <div class="mb-4">
                            @if($user->avatar)
                                <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}" 
                                    class="w-32 h-32 rounded-full ring-4 ring-amber-500/30 object-cover mx-auto">
                            @else
                                <div class="w-32 h-32 rounded-full ring-4 ring-amber-500/30 bg-gradient-to-br from-amber-500 to-orange-600 flex items-center justify-center mx-auto text-white text-5xl font-bold">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                            @endif
                        </div>

                        <!-- Drag & Drop Upload -->
                        <div id="dropZone"
                            class="border-2 border-dashed border-amber-500/30 rounded-lg p-8 cursor-pointer transition-all duration-200 mb-4 hover:border-amber-500 hover:bg-amber-500/10"
                            data-input="avatar">
                            <input type="file" name="avatar" id="avatar" 
                                class="hidden @error('avatar') is-invalid @enderror" accept="image/jpeg,image/png,image/gif,image/jpg">
                            <div class="text-center pointer-events-none">
                                <i class="fas fa-cloud-upload-alt text-amber-500 text-4xl mb-3"></i>
                                <p class="text-slate-300 font-semibold">Click to upload or drag & drop</p>
                                <p class="text-slate-400 text-sm">PNG, JPG, GIF up to 5MB (100x100 to 2000x2000px)</p>
                            </div>
                            @error('avatar')
                                <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Image Preview -->
                        <div id="previewContainer" class="hidden mb-4">
                            <img id="previewImage" src="" alt="Preview" class="w-32 h-32 rounded-full ring-4 ring-green-500/50 object-cover mx-auto animate-pulse">
                            <p class="text-center text-green-400 text-sm mt-2" id="previewText">Preview - Select to confirm or drag another image</p>
                        </div>

                        <!-- Profile Fields -->
                        <div class="space-y-4 mb-6">
                            <div>
                                <label for="name" class="block text-amber-500 font-semibold mb-2">👤 Name</label>
                                <input id="name" name="name" type="text" 
                                    class="w-full bg-slate-900 border border-amber-500/20 text-white rounded-lg px-4 py-2 focus:border-amber-500 focus:ring-1 focus:ring-amber-500/50 outline-none transition @error('name') border-red-500 @enderror" 
                                    value="{{ old('name', $user->name) }}" required autofocus>
                                @error('name')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <label for="email" class="block text-amber-500 font-semibold mb-2">📧 Email</label>
                                <input id="email" name="email" type="email" 
                                    class="w-full bg-slate-900 border border-amber-500/20 text-white rounded-lg px-4 py-2 focus:border-amber-500 focus:ring-1 focus:ring-amber-500/50 outline-none transition @error('email') border-red-500 @enderror" 
                                    value="{{ old('email', $user->email) }}" required>
                                @error('email')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Save Profile Button -->
                        <button type="submit" class="w-full bg-gradient-to-r from-amber-600 to-red-600 hover:from-amber-700 hover:to-red-700 text-white font-bold py-3 rounded-lg transition-all duration-200 flex items-center justify-center gap-2">
                            <i class="fas fa-save"></i> Save Profile Changes
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Security Settings Section -->
        <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-lg border border-blue-500/20 overflow-hidden shadow-2xl mb-6">
            <div class="p-8">
                <h2 class="text-blue-400 text-2xl font-bold mb-6 flex items-center gap-2">
                    <i class="fas fa-lock"></i> Security Settings
                </h2>

                <form method="post" action="{{ route('admin.password.update') }}">
                    @csrf
                    @method('put')

                    <div class="space-y-4 mb-6">
                        <div>
                            <label for="update_password_current_password" class="block text-blue-400 font-semibold mb-2">🔑 Current Password</label>
                            <input id="update_password_current_password" name="current_password" type="password" 
                                class="w-full bg-slate-900 border border-blue-500/20 text-white rounded-lg px-4 py-2 focus:border-blue-500 focus:ring-1 focus:ring-blue-500/50 outline-none transition @error('update_password_current_password') border-red-500 @enderror">
                            @error('update_password_current_password')
                                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <label for="update_password_password" class="block text-blue-400 font-semibold mb-2">🆕 New Password</label>
                            <input id="update_password_password" name="password" type="password" 
                                class="w-full bg-slate-900 border border-blue-500/20 text-white rounded-lg px-4 py-2 focus:border-blue-500 focus:ring-1 focus:ring-blue-500/50 outline-none transition @error('update_password_password') border-red-500 @enderror">
                            @error('update_password_password')
                                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <label for="update_password_password_confirmation" class="block text-blue-400 font-semibold mb-2">✓ Confirm Password</label>
                            <input id="update_password_password_confirmation" name="password_confirmation" type="password" 
                                class="w-full bg-slate-900 border border-blue-500/20 text-white rounded-lg px-4 py-2 focus:border-blue-500 focus:ring-1 focus:ring-blue-500/50 outline-none transition @error('update_password_password_confirmation') border-red-500 @enderror">
                            @error('update_password_password_confirmation')
                                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-cyan-600 hover:from-blue-700 hover:to-cyan-700 text-white font-bold py-3 rounded-lg transition-all duration-200 flex items-center justify-center gap-2">
                        <i class="fas fa-key"></i> Update Password
                    </button>
                </form>
            </div>
        </div>

        <!-- Danger Zone Section -->
        <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-lg border border-red-500/20 overflow-hidden shadow-2xl">
            <div class="p-8">
                <h2 class="text-red-500 text-2xl font-bold mb-6 flex items-center gap-2">
                    <i class="fas fa-exclamation-triangle"></i> Danger Zone
                </h2>

                <div class="bg-red-500/10 border border-red-500/30 rounded-lg p-4 mb-6">
                    <p class="text-slate-300 mb-2">
                        <i class="fas fa-warning text-red-500 mr-2"></i> Once deleted, all resources and data will be permanently removed. This action cannot be undone.
                    </p>
                </div>

                <button type="button" class="w-full bg-gradient-to-r from-red-600 to-rose-600 hover:from-red-700 hover:to-rose-700 text-white font-bold py-3 rounded-lg transition-all duration-200 flex items-center justify-center gap-2" data-toggle="modal" data-target="#deleteAccountModal">
                    <i class="fas fa-trash-alt"></i> Delete Account
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Account Modal -->
<div class="modal fade" id="deleteAccountModal" tabindex="-1" role="dialog" aria-labelledby="deleteAccountModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content bg-gradient-to-br from-slate-900 to-slate-800 border border-red-500/30 text-white">
            <div class="modal-header bg-gradient-to-r from-red-600 to-rose-600 border-red-500/30">
                <h5 class="modal-title text-white font-bold" id="deleteAccountModalLabel">
                    <i class="fas fa-exclamation-circle mr-2"></i> Confirm Account Deletion
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.profile.destroy') }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <div class="bg-red-500/10 border border-red-500/30 rounded-lg p-4 mb-4">
                        <p class="mb-0 text-slate-200">
                            <i class="fas fa-warning text-red-500 mr-2"></i>
                            This action is irreversible. All your data will be permanently removed.
                        </p>
                    </div>
                    
                    <div>
                        <label for="password" class="block text-amber-400 font-semibold mb-2">🔐 Enter Your Password</label>
                        <input type="password" name="password" id="password" 
                            class="w-full bg-slate-900 border border-red-500/30 text-white rounded-lg px-4 py-2 focus:border-red-500 focus:ring-1 focus:ring-red-500/50 outline-none transition @error('password') border-red-500 @enderror" 
                            placeholder="Confirm with password" required>
                        @error('password')
                            <div class="text-red-400 text-sm mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer bg-slate-900/50 border-t border-slate-700">
                    <button type="button" class="btn btn-secondary text-slate-300 border-slate-600 bg-slate-800" data-dismiss="modal">
                        <i class="fas fa-times mr-1"></i> Cancel
                    </button>
                    <button type="submit" class="bg-gradient-to-r from-red-600 to-rose-600 hover:from-red-700 hover:to-rose-700 text-white font-bold py-2 px-4 rounded-lg transition-all duration-200">
                        <i class="fas fa-trash-alt mr-1"></i> Delete Account
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const fileInput = document.getElementById('avatar');
        const dropZone = document.getElementById('dropZone');
        const previewContainer = document.getElementById('previewContainer');
        const previewImage = document.getElementById('previewImage');
        const avatarForm = document.getElementById('avatarForm');

        if (!fileInput || !dropZone) return;

        // Click to upload
        dropZone.addEventListener('click', (e) => {
            if (e.target.closest('button') === null) {
                fileInput.click();
            }
        });

        // Handle file selection
        fileInput.addEventListener('change', handleFileSelect);

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
                dropZone.classList.remove('border-amber-500/30', 'hover:bg-amber-500/10');
            });
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, () => {
                dropZone.classList.remove('border-amber-500', 'bg-amber-500/20');
                dropZone.classList.add('border-amber-500/30', 'hover:bg-amber-500/10');
            });
        });

        dropZone.addEventListener('drop', (e) => {
            const dt = e.dataTransfer;
            const files = dt.files;
            fileInput.files = files;
            fileInput.dispatchEvent(new Event('change', { bubbles: true }));
        });

        // Handle file preview
        function handleFileSelect(e) {
            const file = e.target.files[0];
            if (!file) return;

            // Validate file type
            if (!['image/jpeg', 'image/png', 'image/gif'].includes(file.type)) {
                alert('Please select a valid image file (PNG, JPG, GIF)');
                fileInput.value = '';
                return;
            }

            // Validate file size (5MB)
            if (file.size > 5 * 1024 * 1024) {
                alert('File size must be less than 5MB');
                fileInput.value = '';
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
                        fileInput.value = '';
                        previewContainer.classList.add('hidden');
                        return;
                    }

                    previewImage.src = event.target.result;
                    previewContainer.classList.remove('hidden');
                };
                img.src = event.target.result;
            };
            reader.readAsDataURL(file);
        }

        // Auto-submit on form submit with file selected
        avatarForm.addEventListener('submit', function(e) {
            if (!fileInput.files.length) {
                e.preventDefault();
                alert('Please select an image file');
            }
        });
    });
</script>
@endpush

@endsection