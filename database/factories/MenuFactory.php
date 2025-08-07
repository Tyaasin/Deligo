<?php

namespace Database\Factories;

use App\Models\Menu;
use Illuminate\Database\Eloquent\Factories\Factory;

class MenuFactory extends Factory
{
    protected $model = Menu::class;

    public function definition()
    {
        return [
            'nama_menu' => $this->faker->randomElement([
                'Nasi Goreng Bahagia',
                'Mie Sedih Level 10',
                'Seblak Neraka',
                'Es Teh Mantan',
                'Ayam Geprek Meleduk',
                'Kopi Jomblo',
                'Teh Susu Cinta',
            ]),
            'jenis_menu' => $this->faker->randomElement(['makanan', 'minuman']),
            'harga_menu' => $this->faker->numberBetween(8000, 50000),
            'stok_menu' => $this->faker->numberBetween(5, 30),
            'foto_menu' => null,
        ];
    }
}
