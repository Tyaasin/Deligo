<?php

namespace Database\Factories;

use App\Models\Pembayaran;
use App\Models\Pesanan;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PembayaranFactory extends Factory
{
    protected $model = Pembayaran::class;

    public function definition()
    {
        // return [
        //     'pesanan_id' => Pesanan::factory(),
        //     'pegawai_id' => User::factory()->create(['role' => 'kasir']),
        //     'tanggal_pembayaran' => now()->addMinutes(rand(1, 120)),
        //     'total_pembayaran' => 50000 + rand(-5000, 15000),
        //     'status_pembayaran' => $this->faker->randomElement(['selesai', 'menunggu konfirmasi', 'belum bayar']),
        // ];
    }
}
