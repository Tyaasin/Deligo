@extends('layouts.app')
@section('content')
<div class="container my-5">
  <div class="heading_container heading_center mb-4">
    <h2>Laporan Penjualan</h2>
    <p class="text-muted">Berikut adalah laporan daftar pesanan pelanggan yang sudah dikonfirmasi dari kasir.</p>
  </div>

@if (isset($laporan))
<hr class="my-4">
<div class="table-responsive">
  <table class="table table-bordered table-striped align-middle">
    <thead class="table-light">
      <tr>
        <th>No</th>
        <th>Pelanggan</th>
        <th>Tanggal Bayar</th>
        <th>Total Pembayaran</th>
      </tr>
    </thead>
    <tbody>
      @forelse ($laporan as $item)
      <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $item->pelanggan->name ?? '-' }}</td>
        <td>{{ \Carbon\Carbon::parse($item->pembayaran->tanggal_pembayaran)->format('d-m-Y H:i') ?? '-' }}</td>
        <td>Rp {{ number_format($item->total_pesanan) }}</td>
      </tr>
      @empty
      <tr>
        <td colspan="4" class="text-center text-muted">Tidak ada transaksi hari ini.</td>
      </tr>
      @endforelse
    </tbody>
    <tfoot>
      <tr class="table-light">
        <td colspan="3" class="text-end"><strong>Total</strong></td>
        <td><strong>Rp {{ number_format($total) }}</strong></td>
      </tr>
    </tfoot>
  </table>
</div>
@endif

</div>
@endsection
