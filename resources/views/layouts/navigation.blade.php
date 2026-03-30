<nav x-data="{ open: false }" class="bg-gradient-to-r from-slate-900 via-blue-900 to-slate-900 dark:from-slate-950 dark:via-blue-950 dark:to-slate-950 border-b-2 border-amber-500/30 shadow-lg sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center space-x-2 hover:opacity-80 transition">
                        <div class="bg-gradient-to-r from-amber-500 to-red-600 p-2 rounded-lg">
                            <x-application-logo class="block h-6 w-auto fill-white" />
                        </div>
                        <span class="text-xl font-bold bg-gradient-to-r from-amber-400 via-red-400 to-blue-400 bg-clip-text text-transparent">L.M.C</span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-1 sm:-my-px sm:ms-10 sm:flex">
                    
                    
                    <a href="{{ route('products.index') }}" class="inline-flex items-center px-4 py-2 border-b-2 {{ request()->routeIs('products.*') ? 'border-amber-500 text-amber-400' : 'border-transparent text-gray-300 hover:text-amber-400 hover:border-blue-500' }} text-sm font-medium transition hover:bg-blue-900/20 rounded-t">
                        Shop
                    </a>

                    <!-- Show Cart and My Orders only for non-admin users -->
                    @if(auth()->check() && !auth()->user()->is_admin)
                        <a href="{{ route('cart.index') }}" class="inline-flex items-center px-4 py-2 border-b-2 {{ request()->routeIs('cart.*') ? 'border-amber-500 text-amber-400' : 'border-transparent text-gray-300 hover:text-amber-400 hover:border-blue-500' }} text-sm font-medium transition hover:bg-blue-900/20 rounded-t">
                            Cart
                            @if(session()->has('cart') && count(session('cart')) > 0)
                                <span class="ml-2 bg-gradient-to-r from-amber-500 to-red-600 text-white text-xs rounded-full px-2.5 py-0.5 font-bold">
                                    {{ count(session('cart')) }}
                                </span>
                            @endif
                        </a>
                        
                        <x-nav-link :href="route('orders.index')" :active="request()->routeIs('orders.*')">
                            {{ __('My Orders') }}
                        </x-nav-link>
                    @endif

                    <!-- Admin Panel Link -->
                    @if(auth()->check() && auth()->user()->is_admin)
                        <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.*')" class="text-blue-600 dark:text-blue-400">
                            {{ __('Admin Panel') }}
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                            @if(auth()->check())
                                <!-- Avatar -->
                                <div class="mr-2">
                                    @if(Auth::user()->avatar)
                                        <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Avatar" class="rounded-full h-8 w-8 object-cover">
                                    @else
                                        <div class="rounded-full h-8 w-8 bg-gray-200 dark:bg-gray-600 flex items-center justify-center text-gray-700 dark:text-gray-300">
                                            {{ substr(Auth::user()->name, 0, 1) }}
                                        </div>
                                    @endif
                                </div>
                                <div>{{ Auth::user()->name }}</div>
                            @else
                                <div>{{ __('Guest') }}</div>
                            @endif

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        @if(auth()->check())
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        @else
                            <x-dropdown-link :href="route('login')">
                                {{ __('Log In') }}
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('register')">
                                {{ __('Register') }}
                            </x-dropdown-link>
                        @endif
                    </x-slot>
                </x-dropdown>
            </div>
        </div>
    </div>
</nav>