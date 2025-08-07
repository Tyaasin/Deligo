<div class="row p-2">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h5><b>{{ $title }}</b></h5>

                {{-- Notifikasi sukses --}}
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="/admin/transaksi/{{ $transaksi->id }}" method="POST">
                    @csrf
                    @method('PUT')
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th style="width: 25%">Nama</th>
                            <td>
                                <input type="text" value="{{ $transaksi->user->name }}" class="form-control w-50" readonly>
                            </td>
                        </tr>

                        <tr>
                            <th>Kasir</th>
                            <td>
                                <input type="text" value="{{ $transaksi->kasir_name }}" class="form-control w-50" readonly>
                            </td>
                        </tr>

                        <tr>
                            <th>Waktu Pembayaran</th>
                            <td>
                                <input type="datetime-local" name="waktu_pembayaran"
                                    value="{{ old('waktu_pembayaran', \Carbon\Carbon::parse($transaksi->waktu_pembayaran)->format('Y-m-d\TH:i')) }}"
                                    class="form-control w-50" required>
                            </td>
                        </tr>

                        <tr>
                            <th>Metode Pembayaran</th>
                            <td>
                                <select name="metode_pembayaran" class="form-control w-50" required>
                                    @foreach (['transfer', 'qris'] as $method)
                                        <option value="{{ $method }}" @if(old('metode_pembayaran', $transaksi->metode_pembayaran) == $method) selected @endif>
                                            {{ $method }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>

                        <tr>
                            <th>Total Pembayaran</th>
                            <td>
                                <input type="number" name="total" value="{{ old('total', $transaksi->total) }}" class="form-control w-50" required>
                            </td>
                        </tr>
                    </table>

                    <div class="d-flex justify-content-start">
                        <a href="/admin/transaksi" class="btn bg-red ml-2">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-primary ml-2">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
