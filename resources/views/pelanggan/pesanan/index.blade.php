@extends('layouts.app')

@section('content')
<div class="container my-5">
  <div class="heading_container heading_center mb-4">
    <h2>Detail Pesanan Kamu</h2>
    <p class="text-muted">Ini rekam jejak perjuangan perutmu selama ini 😋</p>
  </div>

  @forelse($pesanans as $pesanan)
    <div class="card mb-4 shadow-sm">
      <div class="card-header bg-light d-flex justify-content-between">
        <strong>ID Pesanan: #{{ $pesanan->id }}</strong>
        <span class="badge py-2 {{ $pesanan->status_pesanan === 'selesai' ? 'bg-success' : 'bg-warning text-dark' }}">
          {{ ucwords($pesanan->status_pesanan) }}
        </span>
      </div>
      <div class="card-body">
        <ul class="list-group list-group-flush mb-3">
          @foreach($pesanan->detail as $detail)
            <li class="list-group-item d-flex justify-content-between">
              <div>
                <strong>{{ $detail->menu->nama_menu }}</strong>
                <span class="text-muted">({{ $detail->menu->jenis_menu }})</span>
                x {{ $detail->jumlah_pesanan }}
              </div>
              <div>
                Rp {{ number_format($detail->subtotal) }}
              </div>
            </li>
          @endforeach
        </ul>
        <div class="text-end">
          <h5 class="text-success">Total: Rp {{ number_format($pesanan->total_pesanan) }}</h5>
          <small class="text-muted">Dipesan pada: {{ $pesanan->tanggal_pesanan }}</small>

          @if($pesanan->status_pesanan === 'belum bayar')
            <div class="row d-flex justify-content-between m-0">
                <div class="mt-3">
                    <a href="{{ route('pelanggan.bayar', $pesanan->id) }}" class="btn btn-primary btn-sm">
                        Bayar Sekarang
                    </a>
                </div>

                <div class="mt-3">
                 <form action="{{ route('pelanggan.batal', $pesanan->id) }}" method="POST">
                   @csrf
                   <button type="submit" class="btn btn-danger btn-sm">
                     Batalkan pesanan
                   </button>
                 </form>
                </div>
            </div>

          @endif
        </div>
      </div>
    </div>
  @empty
    <div class="alert alert-info text-center">
      Kamu belum pernah kenyang dari sini. Ayo mulai pesan sekarang! 🍽️
    </div>
  @endforelse
</div>
@endsection
