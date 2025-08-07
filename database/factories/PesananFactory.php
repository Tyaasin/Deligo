<?php

namespace Database\Factories;

use App\Models\Pesanan;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PesananFactory extends Factory
{
    protected $model = Pesanan::class;

    public function definition()
    {
        // return [
        //     'pelanggan_id' => User::factory()->create(['role' => 'pelanggan']),
        //     'tanggal_pesanan' => now()->subMinutes(rand(0, 1000)),
        //     'total_pesanan' => 0, // default awal, nanti diupdate setelah insert detail
        //     'status_pesanan' => $this->faker->randomElement(['menunggu konfirmasi', 'selesai']),
        // ];
    }
}
