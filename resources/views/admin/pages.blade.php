<div class="container-fluid mt-4">
  <div class="alert alert-success">
    👋 Halo <strong>{{ auth()->user()->name }}</strong>, Selamat datang di halaman admin!
  </div>

  <div class="row">
    <div class="col-md-3 mb-3">
      <div class="card text-white bg-primary shadow text-center">
        <div class="card-body">
          <h5 class="card-title">Total Pengguna</h5>
          <h2 class="display-6 fw-bold">{{ $userCount }}</h2>
        </div>
      </div>
    </div>

    <div class="col-md-3 mb-3">
      <div class="card text-white bg-success shadow text-center">
        <div class="card-body">
          <h5 class="card-title">Total Menu</h5>
          <h2 class="display-6 fw-bold">{{ $menuCount }}</h2>
        </div>
      </div>
    </div>

    <div class="col-md-3 mb-3">
      <div class="card text-white bg-warning shadow text-center">
        <div class="card-body">
          <h5 class="card-title">Total Pesanan</h5>
          <h2 class="display-6 fw-bold">{{ $pesananCount }}</h2>
        </div>
      </div>
    </div>

    <div class="col-md-3 mb-3">
      <div class="card text-white bg-danger shadow text-center">
        <div class="card-body">
          <h5 class="card-title">Total Pembayaran</h5>
          <h2 class="display-6 fw-bold">{{ $pembayaranCount }}</h2>
        </div>
      </div>
    </div>
  </div>
</div>
