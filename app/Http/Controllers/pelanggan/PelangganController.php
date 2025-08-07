<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Pesanan;
use App\Models\DetailPesanan;
use App\Models\Pembayaran;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PelangganController extends Controller
{
    /**
     * Tampilkan halaman menu utama untuk pelanggan
     */
    public function index(Request $request)
    {
        $search = $request->query('search');

        $menus = Menu::where('stok_menu', '>', 0)
            ->when($search, function ($query, $search) {
                $query->where('nama_menu', 'like', '%' . $search . '%');
                $query->orWhere('jenis_menu', 'like', "%$search%");
            })
            ->get();

        return view('pelanggan.menu', compact('menus', 'search'));
    }

    /**
     * Tampilkan riwayat pesanan pelanggan
     */
    public function pesanan()
    {
        $pesanans = Pesanan::with('detail.menu')
            ->where('pelanggan_id', Auth::id())
            ->latest()
            ->get();

        return view('pelanggan.pesanan.index', compact('pesanans'));
    }

    /**
     * Simpan pesanan baru oleh pelanggan
     */
    public function storePesanan(Request $request)
    {
        DB::beginTransaction();

        try {
            $total = 0;
            $items = collect($request->items)->filter(fn($item) => $item['qty'] > 0);

            // Hitung total
            foreach ($items as $item) {
                $menu = Menu::findOrFail($item['menu_id']);
                if ($menu->stok_menu < $item['qty']) {
                    return back()->with('error', 'Stok tidak cukup untuk menu: ' . $menu->nama_menu);
                }
                $total += $menu->harga_menu * $item['qty'];
            }

            // Simpan pesanan
            $pesanan = Pesanan::create([
                'pelanggan_id' => Auth::id(),
                'tanggal_pesanan' => now(),
                'total_pesanan' => $total,
                'status_pesanan' => 'belum bayar'
            ]);

            // Simpan detail
            foreach ($items as $item) {
                $menu = Menu::findOrFail($item['menu_id']);

                DetailPesanan::create([
                    'pesanan_id' => $pesanan->id,
                    'menu_id' => $menu->id,
                    'jumlah_pesanan' => $item['qty'],
                    'subtotal' => $menu->harga_menu * $item['qty']
                ]);

                // Update stok
                $menu->decrement('stok_menu', $item['qty']);
            }

            DB::commit();
            return redirect()->route('pelanggan.pesanan')->with('success', 'Pesanan berhasil disimpan!');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', 'Gagal membuat pesanan. Silakan coba lagi.');
        }
    }

    public function formBayar(Pesanan $pesanan)
    {
        if ($pesanan->pelanggan_id !== Auth::id() || $pesanan->status_pesanan === 'lunas') {
            abort(403);
        }

        return view('pelanggan.pesanan.bayar', compact('pesanan'));
    }

    public function batalBayar(Pesanan $pesanan)
    {
        // Cek apakah user berhak membatalkan
        if ($pesanan->pelanggan_id !== Auth::id() || $pesanan->status_pesanan === 'lunas') {
            abort(403);
        }

        // Hapus pembayaran jika ada
        Pembayaran::where('pesanan_id', $pesanan->id)->delete();

        // Hapus detail pesanan
        $pesanan->detail()->delete(); // pastikan relasi dibuat

        // Hapus pesanan
        $pesanan->delete();

        return redirect()->route('pelanggan.pesanan')->with('success', 'Pesanan berhasil dibatalkan!');
    }

    public function prosesBayar(Request $request, Pesanan $pesanan)
    {

        $request->validate([
            'metode' => 'required|in:transfer,qris',
        ]);

        if ($pesanan->pelanggan_id !== Auth::id() || $pesanan->status_pesanan === 'lunas') {
            abort(403);
        }

        // Simpan pembayaran
        Pembayaran::create([
            'pesanan_id' => $pesanan->id,
            'pegawai_id' => null,
            'tanggal_pembayaran' => Carbon::now(),
            'jenis_pembayaran' => $request->metode,
            'total_pembayaran' => $pesanan->total_pesanan,
            'status_pembayaran' => 'menunggu konfirmasi',
        ]);

        $pesanan->update(['status_pesanan' => 'menunggu konfirmasi']);

        return redirect()->route('pelanggan.pesanan')->with('success', 'Pembayaran berhasil!');
    }
}
