<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use App\Models\Menu;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Database\QueryException;

class AdminProdukController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');

        $query = Menu::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_menu', 'like', "%$search%")
                    ->orWhere('jenis_menu', 'like', "%$search%");
            });
        }

        $data = [
            'title'   => 'Manajemen Menu',
            'produk'  => $query->paginate(10)->withQueryString(),
            'content' => 'admin/produk/index'
        ];

        return view('admin.layouts.wrapper', $data);
    }

    public function create()
    {
        $data = [
            'title'    => 'Tambah Menu',
            'kategori' => Kategori::all(),
            'content'  => 'admin/produk/create'
        ];
        return view('admin.layouts.wrapper', $data);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_menu'     => 'required|string|max:255',
            'jenis_menu'    => 'required|in:makanan,minuman',
            'harga_menu'    => 'required|numeric|min:1000',
            'stok_menu'     => 'required|integer|min:0',
            'foto_menu'     => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('foto_menu')) {
            $file = $request->file('foto_menu');
            $filename = time() . '_' . $file->getClientOriginalName();
            $destinationPath = public_path('images/menus');

            // Buat folder jika belum ada
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            $file->move($destinationPath, $filename);
            $data['foto_menu'] = 'images/menus/' . $filename;
        }

        Menu::create($data);

        Alert::success('Sukses', 'Menu berhasil ditambahkan');
        return redirect('/admin/produk');
    }

    public function edit($id)
    {
        $data = [
            'title'    => 'Edit Menu',
            'produk'   => Menu::findOrFail($id),
            'kategori' => Kategori::all(),
            'content'  => 'admin/produk/edit'
        ];
        return view('admin.layouts.wrapper', $data);
    }

    public function update(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);

        $data = $request->validate([
            'nama_menu'     => 'required|string|max:255',
            'jenis_menu'    => 'required|in:makanan,minuman',
            'harga_menu'    => 'required|numeric|min:1000',
            'stok_menu'     => 'required|integer|min:0',
            'foto_menu'     => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('foto_menu')) {
            // Hapus foto lama jika ada
            if ($menu->foto_menu && file_exists(public_path($menu->foto_menu))) {
                unlink(public_path($menu->foto_menu));
            }

            $file = $request->file('foto_menu');
            $filename = time() . '_' . $file->getClientOriginalName();
            $destinationPath = public_path('images/menus');

            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            $file->move($destinationPath, $filename);
            $data['foto_menu'] = 'images/menus/' . $filename;
        }

        $menu->update($data);

        Alert::success('Sukses', 'Menu berhasil diperbarui');
        return redirect('/admin/produk');
    }


    public function destroy($id)
    {
        try {
            $menu = Menu::findOrFail($id);

            // Hapus gambar jika ada
            if ($menu->foto_menu && file_exists(storage_path('app/public/' . $menu->foto_menu))) {
                unlink(storage_path('app/public/' . $menu->foto_menu));
            }

            // Hapus menu
            $menu->delete();

            Alert::success('Sukses', 'Menu berhasil dihapus');
        } catch (QueryException $e) {
            if ($e->getCode() === '23000') {
                // Foreign key constraint error
                Alert::error('Gagal', 'Menu ini tidak dapat dihapus karena sudah dipesan oleh beberapa pelanggan.');
            } else {
                // Error lain
                Alert::error('Gagal', 'Terjadi kesalahan saat menghapus menu.');
            }
        }

        return redirect()->back();
    }
}
