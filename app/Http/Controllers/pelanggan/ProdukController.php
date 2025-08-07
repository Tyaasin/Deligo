<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    function produk()
    {
        $produk = Menu::all();

        return view('pelanggan.produk.katalog.index', compact('produk'));
    }
}
