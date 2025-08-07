<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pembayaran extends Model
{
    use HasFactory;

    protected $fillable = [
        'pesanan_id',
        'pegawai_id',
        'transaksi_id',
        'total_pembayaran',
        'jenis_pembayaran',
        'status_pembayaran',
        'tanggal_pembayaran',
    ];

    public function transaksi()
    {
        return $this->belongsTo(Pesanan::class);
    }

    public function pegawai()
    {
        return $this->belongsTo(User::class, 'pegawai_id');
    }
}
