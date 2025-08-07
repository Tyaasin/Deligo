<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menu;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DummyPosSeeder extends Seeder
{
    public function run()
    {
        // Seed Menu tetap
        Menu::upsert([
            [
                'nama_menu'   => 'Nasi Goreng Bahagia',
                'jenis_menu'  => 'makanan',
                'harga_menu'  => 15000,
                'stok_menu'   => 25,
                'foto_menu'   => 'images/menus/nasigoreng.jpeg',
            ],
            [
                'nama_menu'   => 'Mie Sedih Level 10',
                'jenis_menu'  => 'makanan',
                'harga_menu'  => 18000,
                'stok_menu'   => 20,
                'foto_menu'   => 'images/menus/mie.jpeg',
            ],
            [
                'nama_menu'   => 'Seblak Neraka',
                'jenis_menu'  => 'makanan',
                'harga_menu'  => 16000,
                'stok_menu'   => 15,
                'foto_menu'   => 'images/menus/seblak.jpeg',
            ],
            [
                'nama_menu'   => 'Es Teh Mantan',
                'jenis_menu'  => 'minuman',
                'harga_menu'  => 5000,
                'stok_menu'   => 30,
                'foto_menu'   => 'images/menus/esteh.jpeg',
            ],
            [
                'nama_menu'   => 'Ayam Geprek Meleduk',
                'jenis_menu'  => 'makanan',
                'harga_menu'  => 20000,
                'stok_menu'   => 10,
                'foto_menu'   => 'images/menus/ayamgeprek.png',
            ],
            [
                'nama_menu'   => 'Kopi Jomblo',
                'jenis_menu'  => 'minuman',
                'harga_menu'  => 12000,
                'stok_menu'   => 12,
                'foto_menu'   => 'images/menus/kopi.jpeg',
            ],
        ], ['nama_menu'], ['jenis_menu', 'harga_menu', 'stok_menu', 'foto_menu']);

        // Seed 3 user tetap
        $users = [
            ['name' => 'Sintya Pelanggan', 'email' => 'pelanggan@gmail.com', 'role' => 'pelanggan'],
            ['name' => 'Sintya Kasir', 'email' => 'kasir@gmail.com', 'role' => 'kasir'],
            ['name' => 'Sintya Admin', 'email' => 'admin@gmail.com', 'role' => 'admin'],
        ];

        foreach ($users as $u) {
            User::updateOrCreate(
                ['email' => $u['email']],
                [
                    'name'            => $u['name'],
                    'role'            => $u['role'],
                    'email_verified_at' => now(),
                    'password'        => Hash::make('Password123!'),
                    'remember_token'  => Str::random(10),
                ]
            );
        }
    }
}
