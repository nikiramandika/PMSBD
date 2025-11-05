<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogPembatalan extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'log_pembatalan';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'transaksi_id',
        'alasan',
        'deleted_at',
        'dibatalkan_oleh',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'deleted_at' => 'datetime',
    ];

    /**
     * Get the transaction that was cancelled (including soft-deleted).
     */
    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transaksi_id')->withTrashed();
    }

    /**
     * Get the user who cancelled the transaction (stored as string).
     */
    public function getPenggunaAttribute()
    {
        return $this->dibatalkan_oleh;
    }

    /**
     * Get formatted details of the cancelled transaction.
     */
    public function getDetailTransaksiAttribute()
    {
        if ($this->transaction) {
            return [
                'id' => $this->transaction->id,
                'customer' => $this->transaction->customer->name ?? 'Tidak diketahui',
                'kasir' => $this->transaction->user->name ?? 'Tidak diketahui',
                'total' => $this->transaction->total_harga,
                'tanggal' => $this->transaction->tanggal,
                'items' => $this->transaction->transactionDetails->count() . ' layanan'
            ];
        }

        return [
            'id' => $this->transaksi_id,
            'customer' => 'Transaksi dihapus',
            'kasir' => 'Tidak diketahui',
            'total' => 0,
            'tanggal' => $this->deleted_at,
            'items' => 'Tidak diketahui'
        ];
    }
}