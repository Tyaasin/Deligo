<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaporanPenjualanExport;
use Carbon\Carbon;

class AdminLaporanPenjualanController extends Controller
{
    public function index()
    {
        $data = [
            'title'   => 'Laporan Penjualan',
            'content' => 'admin.laporan.index',
            'laporan' => null,
            'total'   => 0,
            'start'   => null,
            'end'     => null,
        ];

        return view('admin.layouts.wrapper', $data);
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

    public function exportCsv(Request $request)
    {
        $start = Carbon::parse($request->start_date)->startOfDay();
        $end = Carbon::parse($request->end_date)->endOfDay();

        $laporan = Pesanan::with(['pelanggan', 'pembayaran'])
            ->whereHas('pembayaran', function ($q) use ($start, $end) {
                $q->whereBetween('tanggal_pembayaran', [$start, $end])
                    ->where('status_pembayaran', 'selesai');
            })->get();

        $startFormatted = $start->format('Y-m-d');
        $endFormatted = $end->format('Y-m-d');
        $filename = "laporan-penjualan-{$startFormatted}-sampai-{$endFormatted}.csv";


        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function () use ($laporan) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['No', 'Pelanggan', 'Tanggal Bayar', 'Total']);

            foreach ($laporan as $i => $row) {
                fputcsv($file, [
                    $i + 1,
                    $row->pelanggan->name ?? '-',
                    $row->pembayaran->tanggal_pembayaran ?? '-',
                    $row->total_pesanan
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
