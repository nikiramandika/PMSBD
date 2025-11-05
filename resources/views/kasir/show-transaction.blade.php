<x-app-layout>
    <div class="min-h-screen bg-gray-50 p-4 md:p-6 lg:p-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Detail Transaksi</h1>
                    <p class="text-gray-600 mt-1">Informasi lengkap transaksi #{{ $transaction->id }}</p>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('kasir.transactions') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Kembali
                    </a>
                    @if(!$transaction->trashed())
                    <button onclick="showCancelModal({{ $transaction->id }})" class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        Batalkan Transaksi
                    </button>
                    @endif
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Transaction Info Card -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-lg font-semibold text-gray-900">Informasi Transaksi</h2>
                        @if($transaction->trashed())
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                Dibatalkan
                            </span>
                        @else
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                Selesai
                            </span>
                        @endif
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-1">ID Transaksi</p>
                            <p class="text-lg font-bold text-gray-900">#{{ $transaction->id }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-1">Tanggal</p>
                            <p class="text-lg font-bold text-gray-900">{{ $transaction->tanggal->format('d/m/Y H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-1">Kasir</p>
                            <p class="text-lg font-bold text-gray-900">{{ $transaction->user->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-1">Total Harga</p>
                            <p class="text-lg font-bold text-green-600">Rp {{ number_format($transaction->total_harga, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Customer Info Card -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-6">Informasi Pelanggan</h2>
                    <div class="flex items-center space-x-4">
                        <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-lg font-bold text-gray-900">{{ $transaction->customer->name }}</p>
                            <p class="text-sm text-gray-500">{{ $transaction->customer->phone ?? 'Tidak ada telepon' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Treatment Details Card -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-6">Detail Treatment</h2>
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead>
                                <tr class="border-b border-gray-200">
                                    <th class="text-left py-3 text-sm font-medium text-gray-500">Treatment</th>
                                    <th class="text-center py-3 text-sm font-medium text-gray-500">Qty</th>
                                    <th class="text-right py-3 text-sm font-medium text-gray-500">Harga</th>
                                    <th class="text-right py-3 text-sm font-medium text-gray-500">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($transaction->transactionDetails as $detail)
                                <tr class="hover:bg-gray-50">
                                    <td class="py-4 text-sm text-gray-900 font-medium">{{ $detail->treatment->name }}</td>
                                    <td class="py-4 text-sm text-gray-900 text-center">{{ $detail->qty }}</td>
                                    <td class="py-4 text-sm text-gray-900 text-right">Rp {{ number_format($detail->harga, 0, ',', '.') }}</td>
                                    <td class="py-4 text-sm font-bold text-gray-900 text-right">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="border-t-2 border-gray-200">
                                    <td colspan="3" class="py-4 text-sm font-bold text-gray-900 text-right">Total:</td>
                                    <td class="py-4 text-lg font-bold text-green-600 text-right">Rp {{ number_format($transaction->total_harga, 0, ',', '.') }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Quick Actions -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Aksi Cepat</h3>
                    <div class="space-y-3">
                        <a href="{{ route('kasir.transactions.create') }}" class="w-full inline-flex items-center justify-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Transaksi Baru
                        </a>
                        <a href="{{ route('kasir.customers') }}" class="w-full inline-flex items-center justify-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            Daftar Pelanggan
                        </a>
                        <a href="{{ route('kasir.treatments') }}" class="w-full inline-flex items-center justify-center px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white font-medium rounded-lg transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                            Daftar Treatment
                        </a>
                    </div>
                </div>

                <!-- Transaction Summary -->
                <div class="bg-gradient-to-br from-emerald-50 to-emerald-100 rounded-xl p-6 border border-emerald-200">
                    <h3 class="text-lg font-semibold text-emerald-900 mb-4">Ringkasan</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-emerald-700">Jumlah Treatment:</span>
                            <span class="font-bold text-emerald-900">{{ $transaction->transactionDetails->count() }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-emerald-700">Total Quantity:</span>
                            <span class="font-bold text-emerald-900">{{ $transaction->transactionDetails->sum('qty') }}</span>
                        </div>
                        <div class="flex justify-between items-center pt-3 border-t border-emerald-200">
                            <span class="text-emerald-700 font-medium">Total Harga:</span>
                            <span class="text-xl font-bold text-emerald-900">Rp {{ number_format($transaction->total_harga, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cancellation Modal -->
        <div id="cancelModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden" style="z-index: 9999;">
            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-xl bg-white">
                <div class="mt-3">
                    <div class="flex items-center justify-center w-12 h-12 mx-auto bg-red-100 rounded-full mb-4">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L4.268 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg leading-6 font-bold text-gray-900 text-center mb-2">Batalkan Transaksi?</h3>
                    <div class="mt-2 px-7 py-3">
                        <p class="text-sm text-gray-500 text-center mb-4">Tindakan ini akan membatalkan transaksi <span id="transactionId" class="font-bold"></span> dan tidak dapat dibatalkan.</p>
                        <form id="cancelForm" action="#" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <label for="alasan" class="block text-sm font-medium text-gray-700 mb-1">Alasan Pembatalan <span class="text-red-500">*</span></label>
                                <textarea name="alasan" id="alasan" rows="3" required
                                          class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-red-500 focus:border-red-500 transition-colors"
                                          placeholder="Masukkan alasan pembatalan transaksi..."></textarea>
                            </div>
                            <div class="flex items-center space-x-3 pt-2">
                                <button type="submit" class="flex-1 inline-flex justify-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition-colors">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                    Ya, Batalkan
                                </button>
                                <button type="button" onclick="hideCancelModal()" class="flex-1 inline-flex justify-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition-colors">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                    Batal
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script>
            function showCancelModal(transactionId) {
                const modal = document.getElementById('cancelModal');
                const form = document.getElementById('cancelForm');
                const idSpan = document.getElementById('transactionId');

                idSpan.textContent = '#' + transactionId;
                form.action = '/kasir/transactions/' + transactionId + '/cancel';
                modal.classList.remove('hidden');
                modal.style.display = 'block';

                // Focus on alasan textarea
                setTimeout(() => {
                    document.getElementById('alasan').focus();
                }, 100);
            }

            function hideCancelModal() {
                const modal = document.getElementById('cancelModal');
                const form = document.getElementById('cancelForm');

                modal.classList.add('hidden');
                modal.style.display = 'none';
                form.reset();
            }

            // Close modal when clicking outside
            document.getElementById('cancelModal').addEventListener('click', function(e) {
                if (e.target === this) {
                    hideCancelModal();
                }
            });

            // Close modal on escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    hideCancelModal();
                }
            });
        </script>
    </div>
</x-app-layout>