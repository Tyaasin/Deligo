@extends('layouts.app')

@section('content')
<div class="container my-5">
  <div class="heading_container heading_center mb-4">
    <h2>Katalog Menu</h2>
  </div>

  <form action="{{ route('pelanggan.pesanan.store') }}" method="POST">
    @csrf
    <div class="row">
      @forelse($menus as $menu)
        <div class="col-md-4 mb-4">
          <div class="card shadow-sm h-100">
            <img src="{{ $menu->gambar ? asset('storage/' . $menu->gambar) : asset('images/default-food.jpg') }}" class="card-img-top" alt="{{ $menu->name }}" style="height: 220px; object-fit: cover;">
            <div class="card-body">
              <h5 class="card-title">{{ $menu->name }} 🍴</h5>
              <p class="card-text">
                <strong>Kategori:</strong> {{ $menu->kategori->name }} <br>
                <strong>Harga:</strong> <span style="color:green">Rp {{ number_format($menu->harga) }}</span><br>
                <strong>Stok:</strong>
                @if($menu->stok > 0)
                  <span class="text-success">{{ $menu->stok }} porsi</span>
                  <div class="mt-2">
                    <label>Qty:</label>
                    <input type="number" name="items[{{ $menu->id }}][qty]" min="0" max="{{ $menu->stok }}" class="form-control" placeholder="0">
                    <input type="hidden" name="items[{{ $menu->id }}][produk_id]" value="{{ $menu->id }}">
                  </div>
                @else
                  <span class="text-danger">Habis bro 😭</span>
                @endif
              </p>
            </div>
          </div>
        </div>
      @empty
        <div class="col-12 text-center">
          <p class="text-muted">Belum ada menu tersedia 😢</p>
        </div>
      @endforelse
    </div>

    @if($menus->count() > 0)
      <div class="text-center">
        <button type="submit" class="btn btn-success">Pesan dan Bayar</button>
      </div>
    @endif
  </form>
</div>
@endsection
