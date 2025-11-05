<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-2xl text-gray-900 leading-tight">
                    Dashboard Kasir
                </h2>
                <p class="mt-1 text-sm text-gray-600">Selamat datang kembali, {{ auth()->user()->name }}!</p>
            </div>
            <div class="flex items-center space-x-3">
                <div class="bg-emerald-600 px-4 py-2 rounded-xl">
                    <span class="text-white text-sm font-medium">{{ ucfirst(auth()->user()->role) }}</span>
                </div>
                <div class="text-sm text-gray-500">
                    {{ now()->format('d M Y, H:i') }}
                </div>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6">

        <!-- Quick Actions -->
        <x-card padding="loose">
            <div class="mb-8">
                <h3 class="text-xl font-bold text-gray-900 mb-2">Aksi Cepat</h3>
                <p class="text-gray-600">Lakukan tugas-tugas utama dengan cepat dan efisien</p>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <a href="{{ route('kasir.transactions.create') }}" class="group bg-blue-50 hover:bg-blue-100 rounded-xl p-6 text-center transition-all duration-200 hover:shadow-md border border-blue-200">
                    <div class="mx-auto w-16 h-16 bg-blue-500 rounded-xl flex items-center justify-center mb-4 group-hover:bg-blue-600 transition-colors duration-200">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                    </div>
                    <p class="text-sm font-semibold text-gray-900">Transaksi Baru</p>
                    <p class="text-xs text-gray-500 mt-1">Buat transaksi baru</p>
                </a>

                <a href="{{ route('kasir.transactions') }}" class="group bg-purple-50 hover:bg-purple-100 rounded-xl p-6 text-center transition-all duration-200 hover:shadow-md border border-purple-200">
                    <div class="mx-auto w-16 h-16 bg-purple-500 rounded-xl flex items-center justify-center mb-4 group-hover:bg-purple-600 transition-colors duration-200">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                    <p class="text-sm font-semibold text-gray-900">Lihat Transaksi</p>
                    <p class="text-xs text-gray-500 mt-1">Riwayat transaksi</p>
                </a>

                <a href="{{ route('kasir.customers') }}" class="group bg-emerald-50 hover:bg-emerald-100 rounded-xl p-6 text-center transition-all duration-200 hover:shadow-md border border-emerald-200">
                    <div class="mx-auto w-16 h-16 bg-emerald-500 rounded-xl flex items-center justify-center mb-4 group-hover:bg-emerald-600 transition-colors duration-200">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <p class="text-sm font-semibold text-gray-900">Pelanggan</p>
                    <p class="text-xs text-gray-500 mt-1">Data pelanggan</p>
                </a>

                <a href="{{ route('kasir.treatments') }}" class="group bg-amber-50 hover:bg-amber-100 rounded-xl p-6 text-center transition-all duration-200 hover:shadow-md border border-amber-200">
                    <div class="mx-auto w-16 h-16 bg-amber-500 rounded-xl flex items-center justify-center mb-4 group-hover:bg-amber-600 transition-colors duration-200">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <p class="text-sm font-semibold text-gray-900">Layanan</p>
                    <p class="text-xs text-gray-500 mt-1">Daftar layanan</p>
                </a>
            </div>
        </x-card>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <x-stat-card
                title="Transaksi Hari Ini"
                :value="$todayTransactions"
                color="blue"
            >
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
            </x-stat-card>

            <x-stat-card
                title="Pendapatan Hari Ini"
                :value="'Rp ' . number_format($todayRevenue, 0, ',', '.')"
                color="emerald"
            >
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </x-stat-card>

            <x-stat-card
                title="Total Transaksi Saya"
                :value="$myTransactions"
                color="purple"
            >
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
            </x-stat-card>

            <x-stat-card
                title="Total Pendapatan Saya"
                :value="'Rp ' . number_format($myRevenue, 0, ',', '.')"
                color="amber"
            >
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                </svg>
            </x-stat-card>
        </div>

        <!-- Recent Transactions -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Transaksi Terbaru Saya</h3>
                        <p class="text-sm text-gray-600 mt-1">5 transaksi terakhir yang Anda proses</p>
                    </div>
                    <x-button variant="primary" tag="a" href="{{ route('kasir.transactions') }}">
                        Lihat Semua
                        <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </x-button>
                </div>
            </div>

            @if($recentTransactions->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pelanggan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($recentTransactions as $transaction)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#{{ $transaction->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $transaction->customer->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-green-600">Rp {{ number_format($transaction->total_harga, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $transaction->tanggal->format('d/m/Y H:i') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <x-button variant="secondary" size="sm" tag="a" href="{{ route('kasir.transactions.show', $transaction->id) }}">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        Detail
                                    </x-button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-12">
                    <div class="mx-auto w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada transaksi</h3>
                    <p class="text-gray-600 mb-6">Mulai buat transaksi pertama Anda hari ini</p>
                    <x-button variant="primary" tag="a" href="{{ route('kasir.transactions.create') }}">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Buat Transaksi Pertama
                    </x-button>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>