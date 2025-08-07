@php use Illuminate\Support\Str; @endphp

<div class="row p-2">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">

                <h5><b>Data Katalog Menu</b></h5>

                    @if (session()->has('success'))
                        <div class="alert alert-success mt-2"><i class="fas fa-check"></i>
                            {{ session('success') }}
                        </div>
                    @endif
                <div class="d-flex justify-content-between align-items-center mb-4">
                  <a href="/admin/produk/create" class="btn btn-primary mb-2"><i class="fas fa-plus"></i> Tambah</a>
                  <form action="produk" method="GET" class="d-flex">
                    <input type="text" name="search" class="form-control me-2" placeholder="Cari menu..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-outline-primary">Cari</button>
                  </form>
                </div>

                <table class="table">
                    <tr>
                        <th>No</th>
                        <th>Gambar</th>
                        <th>Name</th>
                        <th>Kategori</th>
                        <th>Action</th>
                    </tr>

                    @foreach ($produk as $item)
                    <tr>

                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <img src="{{ Str::startsWith($item->foto_menu, 'images/') ? asset($item->foto_menu) : asset('storage/' . $item->foto_menu) }}"
                                alt="{{ $item->nama_menu }}"
                                height="150">
                        </td>
                        <td>{{ $item->nama_menu }}</td>
                        <td>{{ $item->jenis_menu }}</td>
                        <td>
                            <div class="d-flex">
                                <a href="/admin/produk/{{ $item->id }}/edit" class="btn btn-info btn-sm"><i class="fas fa-edit"></i></a>
                                {{-- <a href="" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a> --}}
                                <form action="/admin/produk/{{ $item->id }}" method="POST">
                                    @method('delete')
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm ml-1"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach

                </table>

                <div class="d-flex justify-content-center">
                    {{ $produk->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
