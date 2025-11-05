<nav x-data="{ open: false }" class="bg-white shadow-sm border-b border-gray-200">
    <!-- Primary Navigation -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Left Side -->
            <div class="flex items-center space-x-8">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    @if (Auth::user()->role == 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3">
                    @else
                    <a href="{{ route('kasir.dashboard') }}" class="flex items-center space-x-3">
                    @endif
                        <div class="w-10 h-10 bg-slate-700 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </div>
                        <div class="hidden lg:block">
                            <div class="text-xl font-bold text-gray-900">SmartSalon</div>
                            <div class="text-xs text-gray-500">
                                @if(request()->routeIs('admin.*'))
                                    Admin Panel
                                @elseif(request()->routeIs('kasir.*') && Auth::user()->role === 'admin')
                                    Kasir Mode
                                @else
                                    Kasir
                                @endif
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-1">

                    @if(Auth::user()->role === 'admin' && !request()->routeIs('kasir.*'))
                        <!-- Admin Navigation -->
                        <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                            Dashboard
                        </x-nav-link>

                        <x-nav-link :href="route('admin.customers')" :active="request()->routeIs('admin.customers')">
                            Pelanggan
                        </x-nav-link>

                        <x-nav-link :href="route('admin.treatments')" :active="request()->routeIs('admin.treatments')">
                            Layanan
                        </x-nav-link>

                        <x-nav-link :href="route('admin.transactions')" :active="request()->routeIs('admin.transactions')">
                            Transaksi
                        </x-nav-link>

                        <x-nav-link :href="route('admin.cancellation-logs')" :active="request()->routeIs('admin.cancellation-logs')">
                            Log Pembatalan
                        </x-nav-link>

                        <x-nav-link :href="route('admin.users')" :active="request()->routeIs('admin.users')">
                            Pengguna
                        </x-nav-link>

                        <!-- Admin Mode Kasir -->
                        <div class="border-l border-gray-300 h-6 mx-2"></div>

                        <button onclick="window.location.href='{{ route('kasir.dashboard') }}'"
                                class="text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium hover:bg-gray-50">
                            Mode Kasir
                        </button>
                    @endif

                    @if(Auth::user()->role === 'kasir' || (Auth::user()->role === 'admin' && request()->routeIs('kasir.*')))
                        <!-- Kasir Navigation -->
                        <x-nav-link :href="route('kasir.dashboard')" :active="request()->routeIs('kasir.dashboard')">
                            Dashboard
                        </x-nav-link>

                        <x-nav-link :href="route('kasir.transactions.create')" :active="request()->routeIs('kasir.transactions.create')">
                            Transaksi Baru
                        </x-nav-link>

                        <x-nav-link :href="route('kasir.transactions')" :active="request()->routeIs('kasir.transactions')">
                            Riwayat
                        </x-nav-link>

                        <x-nav-link :href="route('kasir.customers')" :active="request()->routeIs('kasir.customers')">
                            Customers
                        </x-nav-link>

                        <x-nav-link :href="route('kasir.treatments')" :active="request()->routeIs('kasir.treatments')">
                            Treatments
                        </x-nav-link>
                    @endif

                    @if(Auth::user()->role === 'admin' && request()->routeIs('kasir.*'))
                        <!-- Admin in Kasir Mode -->
                        <div class="border-l border-gray-300 h-6 mx-2"></div>

                        <button onclick="window.location.href='{{ route('admin.dashboard') }}'"
                                class="text-slate-600 hover:text-slate-900 px-3 py-2 rounded-md text-sm font-medium hover:bg-slate-50 flex items-center space-x-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <span>Admin Mode</span>
                        </button>
                    @endif
                </div>
            </div>

            <!-- Right Side -->
            <div class="flex items-center space-x-4">
                <!-- Notifications -->
                <button class="text-gray-600 hover:text-gray-900 p-1 rounded-full hover:bg-gray-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                    </svg>
                </button>

                <!-- Profile Dropdown -->
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center space-x-3 text-gray-700 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-500 rounded-lg p-2 hover:bg-gray-50">
                            <div class="w-8 h-8 bg-slate-700 rounded-full flex items-center justify-center">
                                <span class="text-white font-medium text-sm">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                            </div>
                            <span class="hidden md:block text-sm font-medium">{{ Auth::user()->name }}</span>
                            <svg class="hidden md:block w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="px-4 py-3 border-b border-gray-200">
                            <div class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</div>
                            <div class="text-sm text-gray-500">{{ Auth::user()->email }}</div>
                            <div class="text-xs text-slate-600 mt-1 capitalize">{{ Auth::user()->role }}</div>
                        </div>

                        <div class="py-1">
                            <x-dropdown-link :href="route('profile.edit')">
                                Profil Saya
                            </x-dropdown-link>
                        </div>

                        <div class="border-t border-gray-100"></div>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();"
                                    class="text-red-600 hover:text-red-700 hover:bg-red-50">
                                Keluar
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>

                <!-- Mobile menu button -->
                <div class="md:hidden">
                    <button @click="open = !open" class="text-gray-600 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-slate-500 p-2">
                        <svg class="h-6 w-6" :class="{'hidden': open, 'block': !open}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                        <svg class="h-6 w-6" :class="{'block': open, 'hidden': !open}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile menu -->
    <div x-show="open" x-collapse class="md:hidden border-t border-gray-200">
        <div class="px-2 pt-2 pb-3 space-y-1">

            @if(Auth::user()->role === 'admin' && !request()->routeIs('kasir.*'))
                <div class="px-3 py-2 text-xs font-semibold text-gray-500 uppercase tracking-wider">Admin Menu</div>

                <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">
                    Dashboard
                </a>

                <a href="{{ route('admin.customers') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">
                    Pelanggan
                </a>

                <a href="{{ route('admin.treatments') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">
                    Layanan
                </a>

                <a href="{{ route('admin.transactions') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">
                    Transaksi
                </a>

                <a href="{{ route('admin.cancellation-logs') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">
                    Log Pembatalan
                </a>

                <a href="{{ route('admin.users') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">
                    Pengguna
                </a>

                <div class="border-t border-gray-200 pt-2 mt-2">
                    <div class="px-3 py-2 text-xs font-semibold text-gray-500 uppercase tracking-wider">Mode</div>
                    <a href="{{ route('kasir.dashboard') }}" class="block px-3 py-2 rounded-md text-base font-medium text-emerald-600 hover:text-emerald-700 hover:bg-emerald-50">
                        Mode Kasir
                    </a>
                </div>
            @endif

            @if(Auth::user()->role === 'kasir' || (Auth::user()->role === 'admin' && request()->routeIs('kasir.*')))
                <div class="px-3 py-2 text-xs font-semibold text-gray-500 uppercase tracking-wider">Kasir Menu</div>

                <a href="{{ route('kasir.dashboard') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">
                    Dashboard
                </a>

                <a href="{{ route('kasir.transactions.create') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">
                    Transaksi Baru
                </a>

                <a href="{{ route('kasir.transactions') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">
                    Riwayat Transaksi
                </a>

                <a href="{{ route('kasir.customers') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">
                    Customers
                </a>

                <a href="{{ route('kasir.treatments') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">
                    Treatments
                </a>

                @if(Auth::user()->role === 'admin' && request()->routeIs('kasir.*'))
                    <div class="border-t border-gray-200 pt-2 mt-2">
                        <div class="px-3 py-2 text-xs font-semibold text-gray-500 uppercase tracking-wider">Mode</div>
                        <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded-md text-base font-medium text-slate-600 hover:text-slate-700 hover:bg-slate-50 flex items-center space-x-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <span>Admin Mode</span>
                        </a>
                    </div>
                @endif
            @endif

            <div class="border-t border-gray-200 pt-2 mt-2">
                <a href="{{ route('profile.edit') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">
                    Profil Saya
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block w-full text-left px-3 py-2 rounded-md text-base font-medium text-red-600 hover:text-red-700 hover:bg-red-50">
                        Keluar
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>