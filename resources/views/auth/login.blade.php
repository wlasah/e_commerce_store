<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="mb-6">
        <h2 class="text-2xl font-bold bg-gradient-to-r from-amber-400 via-red-400 to-blue-400 bg-clip-text text-transparent text-center">Welcome Back</h2>
        <p class="text-center text-gray-400 text-sm mt-2">Sign in to access more features of the shop</p>
    </div>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div class="mb-5">
            <label for="email" class="block text-sm font-semibold text-gray-300 mb-2">
                <i class="fas fa-envelope mr-2 text-amber-400"></i>Email Address
            </label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
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
            <input id="password" type="password" name="password" required autocomplete="current-password"
                class="w-full px-4 py-3 rounded-lg bg-slate-700/50 border border-amber-500/30 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-amber-500/50 focus:border-transparent transition" 
                placeholder="••••••••" />
            @if ($errors->has('password'))
                <p class="mt-2 text-sm text-red-400 flex items-center">
                    <i class="fas fa-exclamation-circle mr-1"></i> {{ $errors->first('password') }}
                </p>
            @endif
        </div>

        <!-- Remember Me -->
        <div class="mb-6 flex items-center">
            <input id="remember_me" type="checkbox" name="remember"
                class="w-4 h-4 rounded bg-slate-700 border-amber-500/30 text-amber-500 focus:ring-2 focus:ring-amber-500/50 cursor-pointer" />
            <label for="remember_me" class="ms-2 text-sm text-gray-400 cursor-pointer hover:text-gray-300">
                Remember me on this device
            </label>
        </div>

        <!-- Buttons -->
        <div class="space-y-3">
            <button type="submit" class="w-full px-4 py-3 bg-gradient-to-r from-amber-600 to-red-600 hover:from-amber-700 hover:to-red-700 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transition transform hover:scale-105">
                <i class="fas fa-sign-in-alt mr-2"></i> Sign In
            </button>
        </div>

        <!-- Divider -->
        <div class="my-5 flex items-center">
            <div class="flex-1 border-t border-amber-500/20"></div>
            <span class="px-3 text-xs text-gray-500">OR</span>
            <div class="flex-1 border-t border-amber-500/20"></div>
        </div>

        <!-- Additional Links -->
        <div class="text-center space-y-2">
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-amber-400 hover:text-amber-300 text-sm font-medium transition flex items-center justify-center">
                    <i class="fas fa-key mr-1"></i> Forgot your password?
                </a>
            @endif
            
            @if (Route::has('register'))
                <a href="{{ route('register') }}" class="text-cyan-400 hover:text-cyan-300 text-sm font-medium transition flex items-center justify-center">
                    <i class="fas fa-user-plus mr-1"></i> Create new account
                </a>
            @endif
        </div>
    </form>
</x-guest-layout>
