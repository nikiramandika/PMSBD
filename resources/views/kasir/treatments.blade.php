<x-app-layout>
    <div class="min-h-screen bg-gray-50 p-4 md:p-6 lg:p-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Daftar Layanan</h1>
                    <p class="text-gray-600 mt-1">Layanan yang tersedia di salon</p>
                </div>
                <a href="{{ route('kasir.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali
                </a>
            </div>
        </div>

        <!-- Treatments Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($treatments as $treatment)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-lg transition-shadow">
                @if($treatment->status === 'active')
                <div class="h-2 bg-gradient-to-r from-green-400 to-green-600"></div>
                @else
                <div class="h-2 bg-gradient-to-r from-red-400 to-red-600"></div>
                @endif

                <div class="p-6">
                    <div class="flex items-start justify-between mb-4">
                        <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        @if($treatment->status === 'active')
                        <span class="px-2 py-1 bg-green-100 text-green-800 text-xs font-medium rounded-full">Aktif</span>
                        @else
                        <span class="px-2 py-1 bg-red-100 text-red-800 text-xs font-medium rounded-full">Tidak Aktif</span>
                        @endif
                    </div>

                    <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $treatment->name }}</h3>

                    <div class="space-y-2 mb-4">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Harga</span>
                            <span class="text-lg font-bold text-green-600">Rp {{ number_format($treatment->price, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Durasi</span>
                            <span class="text-sm font-medium text-gray-900">{{ $treatment->duration }} menit</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Terjual</span>
                            <span class="text-sm font-medium text-gray-900">{{ $treatment->transaction_details_count }}x</span>
                        </div>
                    </div>

                    @if($treatment->status === 'active')
                    <button class="w-full px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                        Tambah ke Transaksi
                    </button>
                    @else
                    <button class="w-full px-4 py-2 bg-gray-300 text-gray-500 font-medium rounded-lg cursor-not-allowed" disabled>
                        Layanan Tidak Tersedia
                    </button>
                    @endif
                </div>
            </div>
            @endforeach
        </div>

        @if($treatments->count() === 0)
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
            <div class="mx-auto w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                </svg>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada layanan</h3>
            <p class="text-gray-600">Tambahkan layanan baru untuk memulai</p>
        </div>
        @endif
    </div>
</x-app-layout>