
@extends('layouts.admin')

@section('title', 'Manage Users')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <!-- Page Header -->
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-4xl font-bold bg-gradient-to-r from-amber-400 via-red-400 to-blue-400 bg-clip-text text-transparent">👥 Manage Users</h1>
            <p class="text-gray-400 mt-2">Manage and monitor all registered users</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="bg-gradient-to-r from-amber-600 to-red-600 hover:from-amber-700 hover:to-red-700 text-white font-bold py-3 px-6 rounded-lg transition-all duration-200 flex items-center gap-2 shadow-lg">
            <i class="fas fa-user-plus"></i> Add User
        </a>
    </div>

    <!-- Users Management Card -->
    <div class="bg-gradient-to-br from-slate-800 to-slate-900 shadow-xl rounded-xl overflow-hidden border border-amber-500/20">
        <!-- Card Header -->
        <div class="px-4 sm:px-6 py-4 border-b border-amber-500/20 bg-gradient-to-r from-blue-900/40 to-red-900/40">
            <div class="flex items-center justify-between flex-col sm:flex-row gap-3">
                <h2 class="text-sm sm:text-lg font-semibold text-amber-300 flex items-center gap-2">
                    <i class="fas fa-list"></i> All Users <span class="bg-amber-500/20 text-amber-300 px-2 sm:px-3 py-1 rounded-full text-xs sm:text-sm border border-amber-500/30">{{ $users->total() }}</span>
                </h2>
                <!-- Search Form -->
                <form class="w-full sm:w-auto" method="GET" action="{{ route('admin.users.index') }}">
                    <div class="flex gap-2">
                        <input type="text" placeholder="Search..." name="search" value="{{ request('search') }}"
                            class="px-3 py-2 bg-slate-900 border border-amber-500/20 text-white rounded-lg focus:border-amber-500 focus:ring-1 focus:ring-amber-500/50 outline-none transition text-sm w-full sm:w-48">
                        <button type="submit" class="bg-amber-600 hover:bg-amber-700 text-white font-semibold px-3 py-2 rounded-lg transition">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full divide-y divide-amber-500/10 text-sm">
                <thead class="bg-gradient-to-r from-blue-900/40 to-red-900/40">
                    <tr>
                        <th class="px-2 sm:px-4 py-2 sm:py-3 text-left text-xs font-semibold text-amber-300 uppercase tracking-wider">ID</th>
                        <th class="px-2 sm:px-4 py-2 sm:py-3 text-left text-xs font-semibold text-amber-300 uppercase tracking-wider">Name</th>
                        <th class="px-2 sm:px-4 py-2 sm:py-3 text-left text-xs font-semibold text-amber-300 uppercase tracking-wider hidden sm:table-cell">Email</th>
                        <th class="px-2 sm:px-4 py-2 sm:py-3 text-left text-xs font-semibold text-amber-300 uppercase tracking-wider">Role</th>
                        <th class="px-2 sm:px-4 py-2 sm:py-3 text-left text-xs font-semibold text-amber-300 uppercase tracking-wider hidden md:table-cell">Status</th>
                        <th class="px-2 sm:px-4 py-2 sm:py-3 text-left text-xs font-semibold text-amber-300 uppercase tracking-wider hidden lg:table-cell">Last Login</th>
                        <th class="px-2 sm:px-4 py-2 sm:py-3 text-left text-xs font-semibold text-amber-300 uppercase tracking-wider hidden lg:table-cell">Created</th>
                        <th class="px-2 sm:px-4 py-2 sm:py-3 text-center text-xs font-semibold text-amber-300 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-amber-500/10">
                    @forelse ($users as $user)
                        <tr class="hover:bg-blue-900/20 transition">
                            <td class="px-2 sm:px-4 py-2 sm:py-4 whitespace-nowrap text-slate-300 font-medium text-xs sm:text-sm">{{ $user->id }}</td>
                            <td class="px-2 sm:px-4 py-2 sm:py-4 whitespace-nowrap">
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-gradient-to-br from-amber-500 to-red-600 flex items-center justify-center text-white font-bold text-xs sm:text-sm overflow-hidden flex-shrink-0">
                                        @if($user->avatar && \Illuminate\Support\Facades\Storage::disk('public')->exists($user->avatar))
                                            <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                                        @else
                                            {{ substr($user->name, 0, 1) }}
                                        @endif
                                    </div>
                                    <span class="text-slate-300 text-xs sm:text-sm truncate">{{ $user->name }}</span>
                                </div>
                            </td>
                            <td class="px-2 sm:px-4 py-2 sm:py-4 whitespace-nowrap text-slate-400 text-xs sm:text-sm hidden sm:table-cell">{{ $user->email }}</td>
                            <td class="px-2 sm:px-4 py-2 sm:py-4 whitespace-nowrap">
                                <span class="px-2 sm:px-3 py-1 inline-flex text-xs leading-4 font-semibold rounded-full 
                                    {{ $user->is_admin ? 'bg-purple-900/40 text-purple-300 border border-purple-500/30' : 'bg-blue-900/40 text-blue-300 border border-blue-500/30' }}">
                                    <i class="fas {{ $user->is_admin ? 'fa-crown' : 'fa-user' }} hidden sm:inline mr-1"></i>
                                    <span class="hidden sm:inline">{{ $user->is_admin ? 'Admin' : 'User' }}</span>
                                    <span class="sm:hidden">{{ $user->is_admin ? 'A' : 'U' }}</span>
                                </span>
                            </td>
                            <td class="px-2 sm:px-4 py-2 sm:py-4 whitespace-nowrap hidden md:table-cell">
                                <span class="px-2 sm:px-3 py-1 inline-flex text-xs leading-4 font-semibold rounded-full 
                                    {{ $user->is_active ? 'bg-green-900/40 text-green-300 border border-green-500/30' : 'bg-red-900/40 text-red-300 border border-red-500/30' }}">
                                    <i class="fas {{ $user->is_active ? 'fa-check-circle' : 'fa-times-circle' }} mr-1"></i>
                                    {{ $user->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="px-2 sm:px-4 py-2 sm:py-4 whitespace-nowrap text-slate-400 text-xs hidden lg:table-cell">
                                {{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Never' }}
                            </td>
                            <td class="px-2 sm:px-4 py-2 sm:py-4 whitespace-nowrap text-slate-400 text-xs hidden lg:table-cell" title="{{ $user->created_at->format('M d, Y H:i') }}">
                                {{ $user->created_at->diffForHumans() }}
                            </td>
                            <td class="px-2 sm:px-4 py-2 sm:py-4 whitespace-nowrap text-center">
                                <div class="flex justify-center gap-1 sm:gap-2">
                                    <a href="{{ route('admin.users.show', $user->id) }}" 
                                       class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-2 sm:px-3 py-2 rounded-lg transition text-xs sm:text-sm"
                                       title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.users.edit', $user->id) }}" 
                                       class="bg-amber-600 hover:bg-amber-700 text-white font-semibold px-2 sm:px-3 py-2 rounded-lg transition text-xs sm:text-sm"
                                       title="Edit User">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" 
                                          method="POST" 
                                          class="inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="bg-red-600 hover:bg-red-700 text-white font-semibold px-2 sm:px-3 py-2 rounded-lg transition text-xs sm:text-sm"
                                                title="Delete User">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center">
                                <div class="text-slate-400">
                                    <i class="fas fa-inbox text-4xl mb-3 block opacity-50"></i>
                                    <p class="mb-4">No users found.</p>
                                    <a href="{{ route('admin.users.create') }}" class="bg-amber-600 hover:bg-amber-700 text-white font-bold py-2 px-4 rounded-lg transition inline-flex items-center gap-2">
                                        <i class="fas fa-user-plus"></i> Create New User
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-amber-500/20 bg-gradient-to-r from-slate-800/50 to-slate-900/50">
            <div class="flex justify-center">
                {{ $users->links('pagination::simple-bootstrap-4') }}
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // SweetAlert for delete confirmation
    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                text: "This user will be permanently deleted!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Yes, delete it!',
                background: '#1e293b',
                color: '#f1f5f9',
                confirmButtonText: '<i class="fas fa-trash mr-2"></i>Yes, delete it!',
                cancelButtonText: '<i class="fas fa-times mr-2"></i>Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            });
        });
    });
</script>
@endsection