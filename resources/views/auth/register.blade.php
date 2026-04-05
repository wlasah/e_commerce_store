<x-guest-layout>
    <div class="mb-6">
        <h2 class="text-2xl font-bold bg-gradient-to-r from-amber-400 via-red-400 to-blue-400 bg-clip-text text-transparent text-center">Create Account</h2>
        <p class="text-center text-gray-400 text-sm mt-2">Register to access the admin dashboard</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div class="mb-5">
            <label for="name" class="block text-sm font-semibold text-gray-300 mb-2">
                <i class="fas fa-user mr-2 text-amber-400"></i>Full Name
            </label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                class="w-full px-4 py-3 rounded-lg bg-slate-700/50 border border-amber-500/30 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-amber-500/50 focus:border-transparent transition" 
                placeholder="lawrence gwapo" />
            @if ($errors->has('name'))
                <p class="mt-2 text-sm text-red-400 flex items-center">
                    <i class="fas fa-exclamation-circle mr-1"></i> {{ $errors->first('name') }}
                </p>
            @endif
        </div>

        <!-- Email Address -->
        <div class="mb-5">
            <label for="email" class="block text-sm font-semibold text-gray-300 mb-2">
                <i class="fas fa-envelope mr-2 text-amber-400"></i>Email Address
            </label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                class="w-full px-4 py-3 rounded-lg bg-slate-700/50 border border-amber-500/30 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-amber-500/50 focus:border-transparent transition" 
                placeholder="user@example.com" />
            @if ($errors->has('email'))
                <p class="mt-2 text-sm text-red-400 flex items-center">
                    <i class="fas fa-exclamation-circle mr-1"></i> {{ $errors->first('email') }}
                </p>
            @endif
        </div>

        <!-- Password -->
        <div class="mb-5">
            <label for="password" class="block text-sm font-semibold text-gray-300 mb-2">
                <i class="fas fa-lock mr-2 text-amber-400"></i>Password
            </label>
            <input id="password" type="password" name="password" required autocomplete="new-password"
                class="w-full px-4 py-3 rounded-lg bg-slate-700/50 border border-amber-500/30 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-amber-500/50 focus:border-transparent transition" 
                placeholder="••••••••" />
            @if ($errors->has('password'))
                <p class="mt-2 text-sm text-red-400 flex items-center">
                    <i class="fas fa-exclamation-circle mr-1"></i> {{ $errors->first('password') }}
                </p>
            @endif
            <p class="mt-1 text-xs text-gray-500">
                <i class="fas fa-info-circle mr-1"></i>
                At least 8 characters with uppercase, lowercase, and numbers
            </p>
        </div>

        <!-- Confirm Password -->
        <div class="mb-6">
            <label for="password_confirmation" class="block text-sm font-semibold text-gray-300 mb-2">
                <i class="fas fa-check-circle mr-2 text-amber-400"></i>Confirm Password
            </label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                class="w-full px-4 py-3 rounded-lg bg-slate-700/50 border border-amber-500/30 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-amber-500/50 focus:border-transparent transition" 
                placeholder="••••••••" />
            @if ($errors->has('password_confirmation'))
                <p class="mt-2 text-sm text-red-400 flex items-center">
                    <i class="fas fa-exclamation-circle mr-1"></i> {{ $errors->first('password_confirmation') }}
                </p>
            @endif
        </div>

        <!-- Buttons -->
        <div class="space-y-3">
            <button type="submit" class="w-full px-4 py-3 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transition transform hover:scale-105">
                <i class="fas fa-user-check mr-2"></i> Create Account
            </button>
        </div>

        <!-- Divider -->
        <div class="my-5 flex items-center">
            <div class="flex-1 border-t border-amber-500/20"></div>
            <span class="px-3 text-xs text-gray-500">HAVE AN ACCOUNT?</span>
            <div class="flex-1 border-t border-amber-500/20"></div>
        </div>

        <!-- Sign In Link -->
        <div class="text-center">
            <a href="{{ route('login') }}" class="text-amber-400 hover:text-amber-300 text-sm font-medium transition flex items-center justify-center">
                <i class="fas fa-sign-in-alt mr-1"></i> Sign In
            </a>
        </div>

        <!-- Terms Note -->
        <p class="mt-4 text-xs text-gray-500 text-center">
            By registering, you agree to our<br />
            <a href="#" class="text-amber-400/70 hover:text-amber-400 transition">Terms of Service</a> and 
            <a href="#" class="text-amber-400/70 hover:text-amber-400 transition">Privacy Policy</a>
        </p>
    </form>
</x-guest-layout>
