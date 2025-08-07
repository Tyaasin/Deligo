<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class AdminTransaksiController extends Controller
{
    public function index()
    {
        $transaksi = Pesanan::with([
            'pelanggan',
            'pembayaran.pegawai'
        ])
            ->whereHas('pelanggan', function ($query) {
                $query->where('role', 'pelanggan');
            })
            ->orderByDesc('created_at')
            ->paginate(10);

        $data = [
            'title'     => 'Manajemen Pesanan',
            'transaksi' => $transaksi,
            'content'   => 'admin/transaksi/index',
        ];

        return view('admin.layouts.wrapper', $data);
    }

    public function show($id)
    {
        $transaksi = Pesanan::with(['detail.menu', 'pelanggan', 'pembayaran'])->findOrFail($id);

        $data = [
            'title'     => 'Detail Transaksi',
            'transaksi' => $transaksi,
            'content'   => 'admin/transaksi/show',
        ];
        return view('admin.layouts.wrapper', $data);
    }

    public function edit($id)
    {
        $transaksi = Pesanan::with('pelanggan')->findOrFail($id);

        $data = [
            'title'     => 'Edit Status Pesanan',
            'transaksi' => $transaksi,
            'content'   => 'admin/transaksi/edit',
        ];
        return view('admin.layouts.wrapper', $data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status_pesanan' => 'required|in:belum bayar,menunggu konfirmasi,lunas',
        ]);

        $pesanan = Pesanan::findOrFail($id);
        $pesanan->update([
            'status_pesanan' => $request->status_pesanan,
        ]);

        Alert::success('Berhasil', 'Status pesanan diperbarui.');
        return redirect()->route('transaksi.index');
    }

    public function destroy($id)
    {
        $pesanan = Pesanan::findOrFail($id);
        $pesanan->delete();

        Alert::success('Berhasil', 'Transaksi berhasil dihapus.');
        return redirect()->route('transaksi.index');
    }
}
