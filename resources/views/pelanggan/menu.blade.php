@extends('layouts.app')

@section('content')

<div class="container my-5">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="m-0">Katalog Menu</h2>
    <form action="{{ route('pelanggan.pages') }}" method="GET" class="d-flex">
      <input type="text" name="search" class="form-control me-2" placeholder="Cari menu..." value="{{ request('search') }}">
      <button type="submit" class="btn btn-outline-primary">Cari</button>
    </form>
  </div>

  <form action="{{ route('pelanggan.pesanan.store') }}" method="POST">
    @csrf
    <div class="row">
      @forelse($menus as $menu)
        <div class="col-md-4 mb-4">
          <div class="card shadow-sm h-100">
            {{-- Gambar menu --}}
            <img src="{{ asset($menu->foto_menu) }}"
                 class="card-img-top"
                 alt="{{ $menu->nama_menu }}"
                 style="height: 220px; object-fit: cover;">

            <div class="card-body">
              <h5 class="card-title">{{ $menu->nama_menu }} 🍴</h5>
              <p class="card-text">
                <strong>Jenis:</strong> {{ ucfirst($menu->jenis_menu) }} <br>
                <strong>Harga:</strong> <span style="color:green">Rp {{ number_format($menu->harga_menu) }}</span><br>
                <strong>Stok:</strong>
                @if($menu->stok_menu > 0)
                  <span class="text-success">{{ $menu->stok_menu }} porsi</span>

                  {{-- Input qty --}}
                  <div class="mt-2">
                    <label for="qty-{{ $menu->id }}">Qty:</label>
                    <input type="number" name="items[{{ $menu->id }}][qty]" min="0" max="{{ $menu->stok_menu }}"
                      class="form-control" placeholder="0" id="qty-{{ $menu->id }}">
                    <input type="hidden" name="items[{{ $menu->id }}][menu_id]" value="{{ $menu->id }}">
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
      <div class="text-center mt-4">
        {{-- Tombol akan aktif jika ada qty yang diisi --}}
        <button type="submit" id="submitBtn" class="btn btn-success px-5 py-2" disabled>Pesan Dan Bayar</button>
      </div>
    @endif
  </form>
</div>
@endsection

{{-- Script aktifkan tombol jika ada qty > 0 --}}
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const qtyInputs = document.querySelectorAll('input[type="number"]');
    const submitBtn = document.getElementById('submitBtn');

    function toggleSubmitButton() {
      const anyQtyFilled = [...qtyInputs].some(input => input.valueAsNumber > 0);
      submitBtn.disabled = !anyQtyFilled;
    }

    qtyInputs.forEach(input => input.addEventListener('input', toggleSubmitButton));
    toggleSubmitButton();
  });
</script>
