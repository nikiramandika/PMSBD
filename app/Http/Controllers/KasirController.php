<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Treatment;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Http\Request;

class KasirController extends Controller
{
    // Middleware akan dihandle di routes

    public function dashboard()
    {
        $todayTransactions = Transaction::getTodayTransactionsCount();
        $todayRevenue = Transaction::getTodayRevenue();

        $myTransactions = Transaction::getUserTransactionsCount(auth()->id());
        $myRevenue = Transaction::getUserRevenue(auth()->id());

        $recentTransactions = Transaction::with(['customer'])
                                       ->where('user_id', auth()->id())
                                       ->active()
                                       ->latest()
                                       ->take(5)
                                       ->get();

        return view('kasir.dashboard', compact(
            'todayTransactions',
            'todayRevenue',
            'myTransactions',
            'myRevenue',
            'recentTransactions'
        ));
    }

    public function createTransaction()
    {
        $customers = Customer::all();
        $treatments = Treatment::active()->get();
        return view('kasir.create-transaction', compact('customers', 'treatments'));
    }

    public function storeTransaction(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'treatments' => 'required|array',
            'treatments.*.id' => 'required|exists:treatments,id',
            'treatments.*.qty' => 'required|integer|min:1'
        ]);

        $totalHarga = 0;
        $transactionDetails = [];

        foreach ($request->treatments as $treatmentData) {
            $treatment = Treatment::findOrFail($treatmentData['id']);
            $qty = $treatmentData['qty'];
            $subtotal = $treatment->price * $qty;
            $totalHarga += $subtotal;

            $transactionDetails[] = [
                'treatment_id' => $treatment->id,
                'harga' => $treatment->price,
                'qty' => $qty,
                'subtotal' => $subtotal
            ];
        }

        $transaction = Transaction::create([
            'customer_id' => $request->customer_id,
            'user_id' => auth()->id(),
            'tanggal' => now(),
            'total_harga' => $totalHarga,
        ]);

        foreach ($transactionDetails as $detail) {
            $detail['transaction_id'] = $transaction->id;
            TransactionDetail::create($detail);
        }

        return redirect()->route('kasir.transactions')->with('success', 'Transaksi berhasil dibuat!');
    }

    public function transactions()
    {
        $transactions = Transaction::with(['customer', 'transactionDetails.treatment'])
                                  ->where('user_id', auth()->id())
                                  ->latest()
                                  ->get();

        // Calculate statistics using MySQL functions for current user
        $userId = auth()->id();
        $stats = [
            'totalTransactions' => Transaction::getUserTransactionsCount($userId),
            'totalRevenue' => Transaction::getUserRevenue($userId),
            'averageTransaction' => Transaction::getUserTransactionsCount($userId) > 0
                ? Transaction::getUserRevenue($userId) / Transaction::getUserTransactionsCount($userId)
                : 0
        ];

        return view('kasir.transactions', compact('transactions', 'stats'));
    }

    public function showTransaction($id)
    {
        $transaction = Transaction::with(['customer', 'user', 'transactionDetails.treatment'])
                                 ->findOrFail($id);
        return view('kasir.show-transaction', compact('transaction'));
    }

    public function customers()
    {
        $customers = Customer::all();
        return view('kasir.customers', compact('customers'));
    }

    public function treatments()
    {
        $treatments = Treatment::active()->get();
        return view('kasir.treatments', compact('treatments'));
    }

    /**
     * Cancel a transaction by updating status to "dibatalkan" using stored procedure (kasir can only cancel their own transactions).
     */
    public function cancelTransaction(Request $request, $id)
    {
        $transaction = Transaction::with(['customer', 'user'])->findOrFail($id);

        // Kasir hanya bisa membatalkan transaksi mereka sendiri
        if ($transaction->user_id !== auth()->id()) {
            return redirect()->back()
                ->with('error', 'Anda hanya bisa membatalkan transaksi yang Anda proses.');
        }

        $request->validate([
            'alasan' => 'required|string|max:255'
        ]);

        // Update status ke "dibatalkan"
        $transaction->update(['status' => 'dibatalkan']);

        // Panggil stored procedure untuk logging dengan data user yang sedang login
        DB::statement('CALL log_pembatalan_procedure(?, ?, ?)', [
            $transaction->id,
            $request->alasan,
            auth()->user()->name
        ]);

        return redirect()->back()
            ->with('success', 'Transaksi #' . $id . ' berhasil dibatalkan.');
    }
}