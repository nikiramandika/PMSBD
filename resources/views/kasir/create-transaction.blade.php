<x-app-layout>
    <div class="min-h-screen  p-4 md:p-6 lg:p-8">
        <!-- Enhanced Header -->
        <div class="mb-8">
            <div class="bg-white/90 backdrop-blur-sm rounded-2xl shadow-lg border border-white/50 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold bg-blue-600 bg-clip-text text-transparent"> Buat Transaksi Baru</h1>
                        <p class="text-gray-600 mt-1">Tambahkan transaksi baru untuk pelanggan dengan mudah dan cepat</p>
                    </div>
                    <a href="{{ route('kasir.dashboard') }}" class="inline-flex items-center px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-xl transition-all duration-300 hover:shadow-md">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Kembali
                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Form -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">Form Transaksi</h2>
                        <p class="text-sm text-gray-600 mt-1">Isi detail transaksi dengan benar</p>
                    </div>
                    <div class="p-6">
                        <form action="{{ route('kasir.transactions.store') }}" method="POST" id="transactionForm">
                            @csrf

                            <!-- Customer Selection -->
                            <div class="mb-6">
                                <label for="customer_id" class="block text-sm font-medium text-gray-700 mb-2">
                                    Pelanggan <span class="text-red-500">*</span>
                                </label>
                                <select name="customer_id" id="customer_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                                    <option value="">Pilih Pelanggan</option>
                                    @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}">{{ $customer->name }} {{ $customer->phone ? '(' . $customer->phone . ')' : '' }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Treatments -->
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Layanan <span class="text-red-500">*</span>
                                </label>
                                <div id="treatmentsContainer" class="space-y-4">
                                    <div class="treatment-item border border-gray-200 rounded-lg p-4 bg-gray-50">
                                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-600 mb-1">Pilih Layanan</label>
                                                <select name="treatments[0][id]" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent treatment-select" required>
                                                    <option value="">Pilih Layanan</option>
                                                    @foreach($treatments as $treatment)
                                                    <option value="{{ $treatment->id }}" data-price="{{ $treatment->price }}" data-duration="{{ $treatment->duration }}">
                                                        {{ $treatment->name }} - Rp {{ number_format($treatment->price, 0, ',', '.') }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-600 mb-1">Qty</label>
                                                <input type="number" name="treatments[0][qty]" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent treatment-qty" value="1" min="1" required>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-600 mb-1">Subtotal</label>
                                                <div class="w-full px-3 py-2 bg-white border border-gray-200 rounded-lg treatment-subtotal font-semibold text-green-600">Rp 0</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <button type="button" onclick="addTreatment()" class="mt-4 inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    Tambah Layanan
                                </button>
                            </div>

                            <!-- Total Summary & Submit -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
                                <div class="bg-gradient-to-r from-blue-50 to-purple-50 rounded-lg p-6 border border-blue-200">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Ringkasan Transaksi</h3>
                                    <div class="space-y-3">
                                        <div class="flex justify-between items-center">
                                            <span class="text-gray-600">Total:</span>
                                            <span class="text-2xl font-bold text-gray-900" id="totalAmount">Rp 0</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-end">
                                    <button type="submit" class="w-full px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-colors flex items-center justify-center">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Simpan Transaksi
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Side Panel - Daftar Layanan -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-yellow-50 to-orange-50">
                        <h3 class="text-lg font-semibold text-gray-900">Daftar Layanan</h3>
                        <p class="text-sm text-gray-600 mt-1">Harga dan durasi layanan</p>
                    </div>
                    <div class="p-6 max-h-96 overflow-y-auto">
                        <div class="space-y-3">
                            @foreach($treatments as $treatment)
                            <div class="border border-gray-200 rounded-lg p-3 hover:bg-gray-50 transition-colors">
                                <div class="flex justify-between items-start mb-2">
                                    <h4 class="font-medium text-gray-900">{{ $treatment->name }}</h4>
                                    <span class="text-sm font-bold text-green-600">Rp {{ number_format($treatment->price, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex items-center text-sm text-gray-500">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $treatment->duration }} menit
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Info Card -->
                <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-blue-800">Tips</h3>
                            <div class="mt-2 text-sm text-blue-700">
                                <p>Pilih pelanggan terlebih dahulu, kemudian tambahkan layanan yang dipesan. Total akan dihitung otomatis.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let treatmentIndex = 0;

        function addTreatment() {
            treatmentIndex++;
            const container = document.getElementById('treatmentsContainer');
            const treatmentItem = document.createElement('div');
            treatmentItem.className = 'treatment-item border border-gray-200 rounded-lg p-4 bg-gray-50';
            treatmentItem.innerHTML = `
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">Pilih Layanan</label>
                        <select name="treatments[${treatmentIndex}][id]" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent treatment-select" required>
                            <option value="">Pilih Layanan</option>
                            @foreach($treatments as $treatment)
                            <option value="{{ $treatment->id }}" data-price="{{ $treatment->price }}" data-duration="{{ $treatment->duration }}">
                                {{ $treatment->name }} - Rp {{ number_format($treatment->price, 0, ',', '.') }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">Qty</label>
                        <input type="number" name="treatments[${treatmentIndex}][qty]" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent treatment-qty" value="1" min="1" required>
                    </div>
                    <div class="relative">
                        <label class="block text-sm font-medium text-gray-600 mb-1">Subtotal</label>
                        <div class="w-full px-3 py-2 bg-white border border-gray-200 rounded-lg treatment-subtotal font-semibold text-green-600">Rp 0</div>
                        <button type="button" onclick="removeTreatment(this.closest('.treatment-item'))" class="absolute -top-2 -right-2 w-6 h-6 bg-red-500 hover:bg-red-600 text-white rounded-full flex items-center justify-center transition-colors">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            `;
            container.appendChild(treatmentItem);
        }

        function removeTreatment(element) {
            element.remove();
            calculateTotal();
        }

        function calculateTotal() {
            let total = 0;
            const treatmentItems = document.querySelectorAll('.treatment-item');

            treatmentItems.forEach(item => {
                const select = item.querySelector('.treatment-select');
                const qty = item.querySelector('.treatment-qty');
                const subtotal = item.querySelector('.treatment-subtotal');

                if (select.value && qty.value) {
                    const price = parseInt(select.options[select.selectedIndex].dataset.price);
                    const quantity = parseInt(qty.value);
                    const itemSubtotal = price * quantity;
                    total += itemSubtotal;
                    subtotal.textContent = 'Rp ' + itemSubtotal.toLocaleString('id-ID');
                } else {
                    subtotal.textContent = 'Rp 0';
                }
            });

            document.getElementById('totalAmount').textContent = 'Rp ' + total.toLocaleString('id-ID');
        }

        // Event listeners
        document.addEventListener('DOMContentLoaded', function() {
            // Initial calculation
            calculateTotal();

            // Listen for changes in treatment selects and quantities
            document.addEventListener('change', function(e) {
                if (e.target.classList.contains('treatment-select') || e.target.classList.contains('treatment-qty')) {
                    calculateTotal();
                }
            });
        });
    </script>
</x-app-layout>