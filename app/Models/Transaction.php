<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'customer_id',
        'user_id',
        'tanggal',
        'total_harga',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'tanggal' => 'datetime',
        'total_harga' => 'decimal:2',
    ];

    
    /**
     * Get the customer that owns the transaction.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get the user that processed the transaction.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the transaction details for the transaction.
     */
    public function transactionDetails()
    {
        return $this->hasMany(TransactionDetail::class);
    }

    /**
     * Calculate total harga from transaction details using MySQL function
     */
    public function getCalculatedTotalAttribute()
    {
        return \DB::selectOne('SELECT calculate_transaction_total(?) as total', [$this->id])->total;
    }

    /**
     * Get today transactions count
     */
    public static function getTodayTransactionsCount()
    {
        return \DB::selectOne('SELECT count_today_transactions() as count')->count;
    }

    /**
     * Get today revenue
     */
    public static function getTodayRevenue()
    {
        return \DB::selectOne('SELECT calculate_today_revenue() as total')->total;
    }

    /**
     * Get month transactions count
     */
    public static function getMonthTransactionsCount()
    {
        return \DB::selectOne('SELECT count_month_transactions() as count')->count;
    }

    /**
     * Get month revenue
     */
    public static function getMonthRevenue()
    {
        return \DB::selectOne('SELECT calculate_month_revenue() as total')->total;
    }

    /**
     * Get year transactions count
     */
    public static function getYearTransactionsCount()
    {
        return \DB::selectOne('SELECT count_year_transactions() as count')->count;
    }

    /**
     * Get year revenue
     */
    public static function getYearRevenue()
    {
        return \DB::selectOne('SELECT calculate_year_revenue() as total')->total;
    }

    /**
     * Get total transactions count
     */
    public static function getTotalTransactionsCount()
    {
        return \DB::selectOne('SELECT count_total_transactions() as count')->count;
    }

    /**
     * Get total revenue
     */
    public static function getTotalRevenue()
    {
        return \DB::selectOne('SELECT calculate_total_revenue() as total')->total;
    }

    /**
     * Get transactions count for specific user
     */
    public static function getUserTransactionsCount($userId)
    {
        return \DB::selectOne('SELECT count_user_transactions(?) as count', [$userId])->count;
    }

    /**
     * Get revenue for specific user
     */
    public static function getUserRevenue($userId)
    {
        return \DB::selectOne('SELECT calculate_user_revenue(?) as total', [$userId])->total;
    }

    /**
     * Scope untuk transaksi hari ini
     */
    public function scopeToday($query)
    {
        return $query->whereDate('tanggal', today());
    }

    /**
     * Scope untuk transaksi bulan ini
     */
    public function scopeThisMonth($query)
    {
        return $query->whereMonth('tanggal', now()->month)
                     ->whereYear('tanggal', now()->year);
    }

    /**
     * Scope untuk transaksi tahun ini
     */
    public function scopeThisYear($query)
    {
        return $query->whereYear('tanggal', now()->year);
    }

    /**
     * Scope untuk transaksi aktif (bukan dibatalkan)
     */
    public function scopeActive($query)
    {
        return $query->where('status', '!=', 'dibatalkan');
    }
}