@extends('layouts.app')
@section('content')
<div class="container my-5">
  <div class="heading_container heading_center mb-4">
    <h2>Daftar Transaksi Menunggu Pembayaran</h2>
    <p class="text-muted">Berikut adalah daftar pesanan pelanggan yang menunggu konfirmasi dari kasir.</p>
  </div>

  @forelse($pesanans as $pesanan)
    <div class="card mb-3 shadow-sm">
      <div class="card-header d-flex justify-content-between bg-light">
        <div><strong>ID #{{ $pesanan->id }}</strong> - {{ $pesanan->pelanggan->name }}</div>
        <form action="{{ route('kasir.transaksi.proses', $pesanan->id) }}" method="POST" class="d-inline">
            @csrf
            <input type="hidden" name="pembayaran_id" value="{{ $pesanan->pembayaran?->id }}">
            <button type="submit" class="btn btn-sm btn-primary">Konfirmasi Pembayaran</button>
        </form>
      </div>
      <div class="card-body">
        <ul class="list-group list-group-flush mb-3">
          @foreach($pesanan->detail as $item)
            <li class="list-group-item d-flex justify-content-between">
              <div>{{ $item->menu->nama_menu }} x {{ $item->jumlah_pesanan }}</div>
              <div>Rp {{ number_format($item->subtotal) }}</div>
            </li>
          @endforeach
        </ul>
        <div class="text-end">
          <strong class="text-success">Total: Rp {{ number_format($pesanan->total_pesanan) }}</strong>
        </div>
      </div>
    </div>
  @empty
    <div class="text-center my-5">
      <h4 class="text-muted">Belum ada pesanan yang perlu dibayar</h4>
    </div>
  @endforelse
</div>
@endsection
