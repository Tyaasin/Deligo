<div class="row p-2">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">

                <h5><b>{{ $title }}</b></h5>
                <hr>

                @isset($produk)
                    <form action="/admin/produk/{{ $produk->id }}" method="POST" enctype="multipart/form-data">
                        @method('PUT')
                @else
                    <form action="/admin/produk" method="POST" enctype="multipart/form-data">
                @endisset

                @csrf
                    <label for="">Nama Produk</label>
                    <input type="text" name="nama_menu" class="form-control @error('nama_menu') is-invalid @enderror" placeholder="Nama Kategori" value="{{ isset($produk) ? $produk->nama_menu : old('nama_menu')  }}">
                    @error('nama_menu')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                   <label for="">Jenis Menu</label>
                   <select name="jenis_menu" class="form-control @error('jenis_menu') is-invalid @enderror">
                     <option value="">Pilih Jenis Menu</option>
                     <option value="makanan" {{ old('jenis_menu', $produk->jenis_menu ?? '') == 'makanan' ? 'selected' : '' }}>Makanan</option>
                     <option value="minuman" {{ old('jenis_menu', $produk->jenis_menu ?? '') == 'minuman' ? 'selected' : '' }}>Minuman</option>
                   </select>
                   @error('jenis_menu')
                   <div class="invalid-feedback">
                     {{ $message }}
                   </div>
                   @enderror

                    <label for="">Harga</label>
                    <input type="number" name="harga_menu" class="form-control @error('harga_menu') is-invalid @enderror" placeholder="harga_menu" value="{{ isset($produk) ? $produk->harga_menu : old('harga_menu')  }}">
                    @error('harga_menu')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                    <label for="">Stok</label>
                    <input type="number" name="stok_menu" class="form-control @error('stok_menu') is-invalid @enderror" placeholder="stok_menu" value="{{ isset($produk) ? $produk->stok_menu : old('stok_menu')  }}">
                    @error('stok_menu')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                    <label for="">Gambar</label>
                    <input type="file" name="foto_menu" class="form-control @error('foto_menu') is-invalid @enderror"  value="{{ isset($produk) ? $produk->foto_menu : old('foto_menu')  }}">
                    @error('foto_menu')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                    @isset($produk)
                        <img src="/{{ $produk->foto_menu }}" width="100px" alt="">
                    @endisset
                    <br>

                    <a href="/admin/produk" class="btn bg-red mt-2"><i class="fas fa-arrow-left"></i> Kembali</a>
                    <button type="submit" class="btn btn-primary mt-2 ml-2"><i class="fas fa-save"></i> Simpan</button>
                </form>

            </div>
        </div>
    </div>
</div>
