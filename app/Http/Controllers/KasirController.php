<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pesanan;
use App\Models\Pembayaran;
use Carbon\Carbon;

class KasirController extends Controller
{
    public function index()
    {
        $pesanans = Pesanan::with('pelanggan', 'detail.menu', 'pembayaran')
            ->where('status_pesanan', 'menunggu konfirmasi')
            ->get();

        return view('kasir.transaksi.index', compact('pesanans'));
    }

    public function riwayat()
    {


        $laporan = Pesanan::with(['pembayaran', 'pelanggan'])
            ->whereHas('pembayaran', function ($query) {
                $query->where('status_pembayaran', 'selesai')
                    ->whereDate('tanggal_pembayaran', Carbon::today());
            })
            ->orderByDesc('created_at')
            ->get();

        $total = $laporan->sum('total_pesanan');

        $data = [
            'title'   => 'Laporan Penjualan',
            'content' => 'admin.laporan.index',
            'laporan' => $laporan,
            'total'   => $total,
        ];
        return view('kasir.laporan.index', $data);
    }


    public function formBayar(Pesanan $pesanan)
    {
        return view('kasir.transaksi.bayar', compact('pesanan'));
    }

    public function prosesBayar(Request $request, Pesanan $pesanan)
    {
        if ($pesanan->status_pesanan === 'lunas') {
            return back()->with('error', 'Pesanan sudah dibayar.');
        }

        $pembayaran = Pembayaran::find($request->pembayaran_id);

        if (!$pembayaran) {
            return back()->with('error', 'Pesanan gagal diterima.');
        }

        $pembayaran->update([
            'pesanan_id' => $pesanan->id,
            'pegawai_id' => Auth::id(),
            'tanggal_pembayaran' => now(),
            'total_pembayaran' => $pesanan->total_pesanan,
            'status_pembayaran' => 'selesai',
        ]);

        $pesanan->update(['status_pesanan' => 'lunas']);

        return redirect()->route('kasir.transaksi.index')->with('success', 'Pesanan berhasil diterima!');
    }

    public function generate(Request $request)
    {
        $start = Carbon::parse($request->start_date)->startOfDay();
        $end = Carbon::parse($request->end_date)->endOfDay();

        $laporan = Pesanan::with(['pembayaran', 'pelanggan'])
            ->whereHas('pembayaran', function ($query) use ($start, $end) {
                $query->whereBetween('tanggal_pembayaran', [$start, $end])
                    ->where('status_pembayaran', 'selesai');
            })
            ->orderByDesc('created_at')
            ->get();

        $total = $laporan->sum('total_pesanan');

        $data = [
            'title'   => 'Laporan Penjualan',
            'content' => 'admin.laporan.index',
            'laporan' => $laporan,
            'total'   => $total,
            'start'   => $request->start_date,
            'end'     => $request->end_date,
        ];

        return view('admin.layouts.wrapper', $data);
    }
}
