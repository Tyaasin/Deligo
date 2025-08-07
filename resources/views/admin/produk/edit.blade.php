<div class="row p-2">
  <div class="col-md-6">
    <div class="card">
      <div class="card-body">

        <h5><b>{{ isset($produk) ? 'Edit Menu' : 'Tambah Menu' }}</b></h5>
        <hr>

        <form
          action="{{ isset($produk) ? route('produk.update', $produk->id) : route('produk.store') }}"
          method="POST"
          enctype="multipart/form-data">
          @csrf
          @if(isset($produk)) @method('PUT') @endif

          <div class="form-group">
            <label>Nama Menu</label>
            <input type="text" name="nama_menu" class="form-control @error('nama_menu') is-invalid @enderror"
              value="{{ old('nama_menu', $produk->nama_menu ?? '') }}" placeholder="Contoh: Nasi Goreng Bahagia">
            @error('nama_menu')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="form-group">
            <label>Jenis Menu</label>
            <select name="jenis_menu" class="form-control @error('jenis_menu') is-invalid @enderror">
              <option value="">Pilih Jenis</option>
              <option value="makanan" {{ old('jenis_menu', $produk->jenis_menu ?? '') == 'makanan' ? 'selected' : '' }}>Makanan</option>
              <option value="minuman" {{ old('jenis_menu', $produk->jenis_menu ?? '') == 'minuman' ? 'selected' : '' }}>Minuman</option>
            </select>
            @error('jenis_menu')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="form-group">
            <label>Harga Menu</label>
            <input type="number" name="harga_menu" class="form-control @error('harga_menu') is-invalid @enderror"
              value="{{ old('harga_menu', $produk->harga_menu ?? '') }}" placeholder="Contoh: 15000">
            @error('harga_menu')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="form-group">
            <label>Stok Menu</label>
            <input type="number" name="stok_menu" class="form-control @error('stok_menu') is-invalid @enderror"
              value="{{ old('stok_menu', $produk->stok_menu ?? '') }}" placeholder="Contoh: 10">
            @error('stok_menu')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="form-group">
            <label>Foto Menu</label>
            <input type="file" name="foto_menu" class="form-control @error('foto_menu') is-invalid @enderror">
            @error('foto_menu')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror

            {{-- @if (isset($produk) && $produk->foto_menu)
              <div class="mt-2">
                <p><b>Gambar saat ini:</b></p>
                <img src="{{ asset($produk->foto_menu) }}" alt="Foto Menu" width="150">
              </div>
            @endif --}}
          </div>

          <a href="{{ route('produk.index') }}" class="btn btn-secondary mt-2">
            <i class="fas fa-arrow-left"></i> Kembali
          </a>
          <button type="submit" class="btn btn-primary mt-2 ml-2">
            <i class="fas fa-save"></i> Simpan
          </button>
        </form>

      </div>
    </div>
  </div>
</div>
