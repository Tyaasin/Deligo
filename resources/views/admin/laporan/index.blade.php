<div class="container pt-5">
    <h2 class="mb-3">Filter Laporan Penjualan</h2>
    <p class="text-muted">Silakan pilih rentang tanggal laporan.</p>

    {{-- Form to Generate and Display the Report --}}
    <form action="{{ route('admin.laporan.generate') }}" method="POST" class="row g-3 align-items-end mb-4">
      @csrf
      <div class="col-md-4">
        <label for="start_date" class="form-label">Dari Tanggal</label>
        {{-- Fixed: Added old() helper for repopulation --}}
        <input type="date" name="start_date" id="start_date" class="form-control" required value="{{ old('start_date', $start ?? '') }}">
      </div>
      <div class="col-md-4">
        <label for="end_date" class="form-label">Sampai Tanggal</label>
        <input type="date" name="end_date" id="end_date" class="form-control" required value="{{ old('end_date', $end ?? '') }}">
      </div>
      <div class="col-md-4">
        <button type="submit" class="btn btn-primary w-100">Tampilkan</button>
      </div>
    </form>

    {{-- download csv --}}
    @if (isset($start) && isset($end))
    <div class="row">
      <div class="col-md-3">
        <form action="{{ route('admin.laporan.csv') }}" method="GET">
          {{-- Pass the current date range as hidden inputs --}}
          <input type="hidden" name="start_date" value="{{ $start }}">
          <input type="hidden" name="end_date" value="{{ $end }}">
          <button type="submit" class="btn btn-success">Download CSV</button>
        </form>
      </div>
    </div>
    @endif


    @if (isset($laporan))
        <hr class="my-4">
        <h4>Hasil Laporan Penjualan</h4>
        <p class="text-muted">Periode: <strong>{{ $start }}</strong> s.d. <strong>{{ $end }}</strong></p>

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
                            <td colspan="4" class="text-center text-muted">Tidak ada data ditemukan.</td>
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
