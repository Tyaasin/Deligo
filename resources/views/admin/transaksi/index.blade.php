<div class="row p-2">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h5><b>DATA PEMBAYARAN</b></h5>

                    @if (session()->has('success'))
                        <div class="alert alert-success mt-2"><i class="fas fa-check"></i>
                            {{ session('success') }}
                        </div>
                    @endif

                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Kasir</th>
                            <th>Waktu Pembayaran</th>
                            <th>Metode Pembayaran</th>
                            <th>Total Pembayaran</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transaksi as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->pelanggan->name }} </td>
                            <td>{{ $item->pembayaran->pegawai->name }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->waktu_pembayaran)->format('d-m-Y H:i') }}</td>
                            <td>{{ ucwords($item->pembayaran->jenis_pembayaran) }}</td>
                            <td>Rp {{ number_format($item->total_pesanan, 0, ',', '.') }}</td>
                            <td>
                                <div class="d-flex">
                                    {{-- <a href="/admin/transaksi/{{ $item->id }}/edit" class="btn btn-info btn-sm">
                                        <i class="fas fa-edit"></i> Edit
                                    </a> --}}
                                    <form action="/admin/transaksi/{{ $item->id }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm ml-1">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="d-flex justify-content-center">
                    {{ $transaksi->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
