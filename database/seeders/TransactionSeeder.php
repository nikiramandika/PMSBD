<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Treatment;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kasirs = User::where('role', 'kasir')->get();
        $customers = Customer::all();
        $treatments = Treatment::all();

        if ($kasirs->isEmpty()) {
            $this->command->error('❌ No kasir users found. Please run UserSeeder first.');
            return;
        }

        // Sample transactions with realistic data
        $sampleTransactions = [
            [
                'customer_name' => 'Andi Wijaya',
                'treatments' => ['Potong Rambut Pria', 'Cuci Rambut'],
                'tanggal' => now()->subDays(10)->format('Y-m-d H:i:s'),
                'kasir_name' => 'Kasir Salon',
                'status' => 'selesai'
            ],
            [
                'customer_name' => 'Siti Nurhaliza',
                'treatments' => ['Creambath', 'Hair Spa'],
                'tanggal' => now()->subDays(9)->format('Y-m-d H:i:s'),
                'kasir_name' => 'Sarah Putri',
                'status' => 'selesai'
            ],
            [
                'customer_name' => 'Ahmad Fauzi',
                'treatments' => ['Smoothing'],
                'tanggal' => now()->subDays(8)->format('Y-m-d H:i:s'),
                'kasir_name' => 'Budi Santoso',
                'status' => 'selesai'
            ],
            [
                'customer_name' => 'Dewi Lestari',
                'treatments' => ['Hair Coloring', 'Blow Styling'],
                'tanggal' => now()->subDays(7)->format('Y-m-d H:i:s'),
                'kasir_name' => 'Kasir Salon',
                'status' => 'selesai'
            ],
            [
                'customer_name' => 'Rizky Aditya',
                'treatments' => ['Potong Rambut Pria', 'Hair Mask'],
                'tanggal' => now()->subDays(6)->format('Y-m-d H:i:s'),
                'kasir_name' => 'Sarah Putri',
                'status' => 'selesai'
            ],
            [
                'customer_name' => 'Maya Sari',
                'treatments' => ['Keratin Treatment'],
                'tanggal' => now()->subDays(5)->format('Y-m-d H:i:s'),
                'kasir_name' => 'Budi Santoso',
                'status' => 'selesai'
            ],
            [
                'customer_name' => 'Eko Prasetyo',
                'treatments' => ['Highlight', 'Hair Volume'],
                'tanggal' => now()->subDays(4)->format('Y-m-d H:i:s'),
                'kasir_name' => 'Kasir Salon',
                'status' => 'selesai'
            ],
            [
                'customer_name' => 'Indah Permata',
                'treatments' => ['Potong Rambut Wanita', 'Hair Mask', 'Blow Styling'],
                'tanggal' => now()->subDays(3)->format('Y-m-d H:i:s'),
                'kasir_name' => 'Sarah Putri',
                'status' => 'selesai'
            ],
            [
                'customer_name' => 'Fajar Nugroho',
                'treatments' => ['Hair Extension'],
                'tanggal' => now()->subDays(2)->format('Y-m-d H:i:s'),
                'kasir_name' => 'Budi Santoso',
                'status' => 'selesai'
            ],
            [
                'customer_name' => 'Ratna Wijaya',
                'treatments' => ['Scalp Treatment', 'Hair Spa'],
                'tanggal' => now()->subDays(1)->format('Y-m-d H:i:s'),
                'kasir_name' => 'Kasir Salon',
                'status' => 'selesai'
            ],
            [
                'customer_name' => 'Sarah Amanda',
                'treatments' => ['Bleaching', 'Hair Coloring'],
                'tanggal' => now()->format('Y-m-d H:i:s'),
                'kasir_name' => 'Sarah Putri',
                'status' => 'selesai'
            ],
        ];

        $createdTransactions = 0;

        foreach ($sampleTransactions as $sample) {
            $customer = $customers->where('name', $sample['customer_name'])->first();
            $kasir = $kasirs->where('name', $sample['kasir_name'])->first();

            if (!$customer || !$kasir) continue;

            $totalHarga = 0;
            $transactionDetails = [];

            foreach ($sample['treatments'] as $treatmentName) {
                $treatment = $treatments->where('name', $treatmentName)->first();
                if (!$treatment) continue;

                $qty = 1;
                $subtotal = $treatment->price * $qty;
                $totalHarga += $subtotal;

                $transactionDetails[] = [
                    'treatment_id' => $treatment->id,
                    'harga' => $treatment->price,
                    'qty' => $qty,
                    'subtotal' => $subtotal
                ];
            }

            if (!empty($transactionDetails)) {
                $transaction = Transaction::create([
                    'customer_id' => $customer->id,
                    'user_id' => $kasir->id,
                    'tanggal' => $sample['tanggal'],
                    'total_harga' => $totalHarga,
                    'status' => $sample['status'],
                ]);

                foreach ($transactionDetails as $detail) {
                    $detail['transaction_id'] = $transaction->id;
                    TransactionDetail::create($detail);
                }

                $createdTransactions++;
            }
        }

        $this->command->info("✅ {$createdTransactions} transactions created successfully!");
        $this->command->info("💰 Total revenue: Rp " . number_format(Transaction::sum('total_harga'), 0, ',', '.'));
    }
}