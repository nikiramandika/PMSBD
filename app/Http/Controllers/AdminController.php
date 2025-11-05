<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Treatment;
use App\Models\Transaction;
use App\Models\User;
use App\Models\LogPembatalan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    // Middleware akan dihandle di routes

    public function dashboard()
    {
        $totalCustomers = Customer::count();
        $totalTreatments = Treatment::count();
        $totalTransactions = Transaction::getTotalTransactionsCount();
        $totalRevenue = Transaction::getTotalRevenue();

        $todayTransactions = Transaction::getTodayTransactionsCount();
        $todayRevenue = Transaction::getTodayRevenue();

        $monthlyTransactions = Transaction::getMonthTransactionsCount();
        $monthlyRevenue = Transaction::getMonthRevenue();

        $yearTransactions = Transaction::getYearTransactionsCount();
        $yearRevenue = Transaction::getYearRevenue();

        $recentTransactions = Transaction::with(['customer', 'user'])
                                       ->active()
                                       ->latest()
                                       ->take(5)
                                       ->get();

        $topTreatments = Treatment::withCount('transactionDetails')
                                 ->orderBy('transaction_details_count', 'desc')
                                 ->take(5)
                                 ->get();

        return view('admin.dashboard', compact(
            'totalCustomers',
            'totalTreatments',
            'totalTransactions',
            'totalRevenue',
            'todayTransactions',
            'todayRevenue',
            'monthlyTransactions',
            'monthlyRevenue',
            'yearTransactions',
            'yearRevenue',
            'recentTransactions',
            'topTreatments'
        ));
    }

    public function customers()
    {
        $customers = Customer::withCount('transactions')->get();
        return view('admin.customers', compact('customers'));
    }

    public function treatments()
    {
        $treatments = Treatment::withCount('transactionDetails')->get();
        return view('admin.treatments', compact('treatments'));
    }

    public function transactions()
    {
        $transactions = Transaction::with(['customer', 'user', 'transactionDetails.treatment'])
                                  ->latest()
                                  ->get();

        // Calculate statistics using MySQL functions
        $stats = [
            'totalTransactions' => Transaction::getTotalTransactionsCount(),
            'totalRevenue' => Transaction::getTotalRevenue(),
            'todayTransactions' => Transaction::getTodayTransactionsCount(),
            'averageTransaction' => Transaction::getTotalTransactionsCount() > 0
                ? Transaction::getTotalRevenue() / Transaction::getTotalTransactionsCount()
                : 0
        ];

        return view('admin.transactions', compact('transactions', 'stats'));
    }

    public function users()
    {
        $users = User::where('role', '!=', 'admin')->get();
        return view('admin.users', compact('users'));
    }

    /**
     * Cancel a transaction dengan 3 tipe transaction approach.
     */
    public function cancelTransaction(Request $request, $id)
    {
        $transaction = Transaction::with(['customer', 'user'])->findOrFail($id);

        $request->validate([
            'alasan' => 'required|string|max:255'
        ]);

        // ===============================================
        // TIPE 1: MySQL Transaction (Manual SQL + Stored Procedure)
        // ===============================================
        try {
            DB::beginTransaction();

            // Update status menggunakan raw SQL
            DB::update("
                UPDATE transactions
                SET status = 'dibatalkan', updated_at = NOW()
                WHERE id = ?
            ", [$id]);

            // Panggil stored procedure untuk logging
            DB::statement('CALL log_pembatalan_procedure(?, ?, ?)', [
                $id,
                $request->alasan,
                auth()->user()->name
            ]);

            DB::commit();
            return redirect()->back()
                ->with('success', 'Transaksi #' . $id . ' berhasil dibatalkan dengan MySQL Transaction!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal membatalkan transaksi: ' . $e->getMessage());
        }

        // ========================================================
        // TIPE 2: Laravel DB Builder Transaction + Stored Procedure
        // ========================================================
        /*
        try {
            DB::beginTransaction();

            // Update status menggunakan DB Builder
            DB::table('transactions')
                ->where('id', $id)
                ->update([
                    'status' => 'dibatalkan',
                    'updated_at' => now()
                ]);

            // Panggil stored procedure untuk logging
            DB::statement('CALL log_pembatalan_procedure(?, ?, ?)', [
                $id,
                $request->alasan,
                auth()->user()->name
            ]);

            DB::commit();
            return redirect()->back()
                ->with('success', 'Transaksi #' . $id . ' berhasil dibatalkan dengan DB Builder Transaction!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal membatalkan transaksi: ' . $e->getMessage());
        }
        */

        // ====================================================
        // TIPE 3: Laravel Eloquent Transaction + Stored Procedure
        // ====================================================
        /*
        try {
            DB::beginTransaction();

            // Update status menggunakan Eloquent
            $transaction->update(['status' => 'dibatalkan']);

            // Panggil stored procedure untuk logging
            DB::statement('CALL log_pembatalan_procedure(?, ?, ?)', [
                $transaction->id,
                $request->alasan,
                auth()->user()->name
            ]);

            DB::commit();
            return redirect()->back()
                ->with('success', 'Transaksi #' . $id . ' berhasil dibatalkan dengan Laravel Eloquent Transaction!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal membatalkan transaksi: ' . $e->getMessage());
        }
        */
    }

    /**
     * Show cancellation logs.
     */
    public function cancellationLogs()
    {
        $logs = LogPembatalan::latest('deleted_at')->get();

        return view('admin.cancellation-logs', compact('logs'));
    }
}