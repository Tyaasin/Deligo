@extends('layouts.app')
@section('content')
<div class="container my-5">
  <h3>Pembayaran #{{ $pesanan->id }}</h3>
  <p>Pelanggan: <strong>{{ $pesanan->pelanggan->name }}</strong></p>
  <p>Total: <strong class="text-success">Rp {{ number_format($pesanan->total_pesanan) }}</strong></p>
  <form action="{{ route('kasir.transaksi.proses', $pesanan->id) }}" method="POST">
    @csrf
    <div class="form-group mb-3">
      <label>Metode Pembayaran:</label>
      <select name="metode" class="form-control" required>
        <option value="">-- Pilih --</option>
        <option value="transfer">Transfer</option>
        <option value="qris">QRIS</option>
      </select>
    </div>
    <button type="submit" class="btn btn-success">Konfirmasi Pembayaran</button>
  </form>
</div>
@endsection
