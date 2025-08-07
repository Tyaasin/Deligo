<?php

namespace Database\Factories;

use App\Models\DetailPesanan;
use App\Models\Menu;
use App\Models\Pesanan;
use Illuminate\Database\Eloquent\Factories\Factory;

class DetailPesananFactory extends Factory
{
    protected $model = DetailPesanan::class;

    public function definition()
    {
        // $menu = Menu::inRandomOrder()->first() ?? Menu::factory()->create();
        // $qty = $this->faker->numberBetween(1, 5);
        // return [
        //     'pesanan_id' => Pesanan::factory(),
        //     'menu_id' => $menu->id,
        //     'jumlah_pesanan' => $qty,
        //     'subtotal' => $menu->harga_menu * $qty,
        // ];
    }
}
