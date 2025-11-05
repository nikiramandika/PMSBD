<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-2xl text-gray-900 leading-tight">
                    Dashboard Admin
                </h2>
                <p class="mt-1 text-sm text-gray-600">Ringkasan bisnis salon Anda</p>
            </div>
            <div class="flex items-center space-x-3">
                <div class="bg-slate-600 px-4 py-2 rounded-xl">
                    <span class="text-white text-sm font-medium">{{ ucfirst(auth()->user()->role) }}</span>
                </div>
                <div class="text-sm text-gray-500">
                    {{ now()->format('d M Y, H:i') }}
                </div>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <x-stat-card
                title="Total Pelanggan"
                :value="$totalCustomers"
                :trend="['value' => 8, 'label' => 'dari bulan lalu']"
                color="blue"
            >
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            </x-stat-card>

            <x-stat-card
                title="Total Layanan"
                :value="$totalTreatments"
                :trend="['value' => 2, 'label' => 'layanan baru']"
                color="emerald"
            >
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
            </x-stat-card>

            <x-stat-card
                title="Total Transaksi"
                :value="$totalTransactions"
                :trend="['value' => 15, 'label' => 'dari bulan lalu']"
                color="purple"
            >
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
            </x-stat-card>

            <x-stat-card
                title="Total Pendapatan"
                :value="'Rp ' . number_format($totalRevenue, 0, ',', '.')"
                :trend="['value' => 12, 'label' => 'dari bulan lalu']"
                color="amber"
            >
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </x-stat-card>
        </div>

        <!-- Today & Monthly Overview -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Hari Ini -->
            <x-card title="Statistik Hari Ini" padding="loose">
                <div class="flex items-center justify-center mb-6">
                    <div class="w-12 h-12 bg-blue-50 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-6">
                    <div class="text-center">
                        <p class="text-3xl font-bold text-blue-600">{{ $todayTransactions }}</p>
                        <p class="text-sm text-gray-600 mt-1">Transaksi</p>
                    </div>
                    <div class="text-center">
                        <p class="text-3xl font-bold text-emerald-600">Rp {{ number_format($todayRevenue, 0, ',', '.') }}</p>
                        <p class="text-sm text-gray-600 mt-1">Pendapatan</p>
                    </div>
                </div>
            </x-card>

            <!-- Bulan Ini -->
            <x-card title="Statistik Bulan Ini" padding="loose">
                <div class="flex items-center justify-center mb-6">
                    <div class="w-12 h-12 bg-purple-50 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-6">
                    <div class="text-center">
                        <p class="text-3xl font-bold text-purple-600">{{ $monthlyTransactions }}</p>
                        <p class="text-sm text-gray-600 mt-1">Transaksi</p>
                    </div>
                    <div class="text-center">
                        <p class="text-3xl font-bold text-amber-600">Rp {{ number_format($monthlyRevenue, 0, ',', '.') }}</p>
                        <p class="text-sm text-gray-600 mt-1">Pendapatan</p>
                    </div>
                </div>
            </x-card>
        </div>

        <!-- Recent Transactions & Top Treatments -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Recent Transactions -->
            <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Transaksi Terbaru</h3>
                            <p class="text-sm text-gray-600 mt-1">5 transaksi terakhir</p>
                        </div>
                        <a href="{{ route('admin.transactions') }}"
                           class="inline-flex items-center px-4 py-2 bg-slate-600 hover:bg-slate-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                            Lihat Semua
                            <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    @if($recentTransactions->count() > 0)
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pelanggan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kasir</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($recentTransactions as $transaction)
                                <tr class="hover:bg-gray-50 transition-colors duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#{{ $transaction->id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $transaction->customer->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $transaction->user->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-green-600">Rp {{ number_format($transaction->total_harga, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $transaction->tanggal->format('d/m/Y H:i') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="text-center py-12">
                            <div class="mx-auto w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada transaksi</h3>
                            <p class="text-gray-600">Mulai transaksi pertama akan segera muncul di sini</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Top Treatments -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 bg-amber-50 border-b border-amber-200">
                    <h3 class="text-lg font-semibold text-gray-900">Layanan Terpopuler</h3>
                    <p class="text-sm text-gray-600 mt-1">Layanan paling diminati</p>
                </div>
                <div class="p-6">
                    @if($topTreatments->count() > 0)
                        <div class="space-y-4">
                            @foreach($topTreatments as $index => $treatment)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 bg-amber-500 rounded-lg flex items-center justify-center text-white font-semibold text-sm">
                                        {{ $index + 1 }}
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900 text-sm">{{ $treatment->name }}</p>
                                        <p class="text-xs text-gray-500">{{ $treatment->transaction_details_count }} transaksi</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-bold text-gray-900">Rp {{ number_format($treatment->price, 0, ',', '.') }}</p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <div class="mx-auto w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center mb-3">
                                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                            </div>
                            <p class="text-gray-500 text-sm">Belum ada data layanan</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-slate-600 rounded-xl p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-xl font-bold mb-2">Aksi Cepat Admin</h3>
                    <p class="text-slate-200">Kelola sistem dengan efisien menggunakan aksi cepat berikut</p>
                </div>
                <div class="hidden lg:flex space-x-4">
                    <a href="{{ route('admin.customers') }}"
                       class="inline-flex items-center px-4 py-2 bg-slate-700 hover:bg-slate-800 border border-slate-500 rounded-lg transition-all duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        Kelola Pelanggan
                    </a>
                    <a href="{{ route('admin.treatments') }}"
                       class="inline-flex items-center px-4 py-2 bg-slate-700 hover:bg-slate-800 border border-slate-500 rounded-lg transition-all duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                        Kelola Layanan
                    </a>
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.users') }}"
                           class="inline-flex items-center px-4 py-2 bg-slate-700 hover:bg-slate-800 border border-slate-500 rounded-lg transition-all duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                            </svg>
                            Kelola Users
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>