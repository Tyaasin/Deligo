<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Deligo</title>

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">

  <!-- Custom CSS -->
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Poppins:400,600,700&display=swap" rel="stylesheet">

  <!-- Font Awesome CDN (optional) -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="d-flex flex-column min-vh-100">

  <!-- Header -->
  <header class="footer_section">
    <div class="container-fluid">
      <nav class="navbar navbar-expand-lg custom_nav-container">
        <a class="navbar-brand" href="@auth
           @if(Auth::user()->role === 'kasir')
             {{ route('kasir.transaksi.index') }}
           @elseif(Auth::user()->role === 'pelanggan')
             {{ route('pelanggan.pages') }}
           @endif
         @else
           {{ route('/') }}
         @endauth">>

          <span>Deligo</span>
        </a>
        <div class="User_option">
          @guest
            <!-- Jika belum login -->
            <a href="{{ route('login') }}">
              <i class="fa fa-user" aria-hidden="true"></i>
              <span>Login</span>
            </a>
          @endguest

          @auth
            @if(Auth::user()->role === 'kasir')
            <a href="{{ route('kasir.riwayat.riwayat') }}" class="position-relative">
               <span>Laporan Penjualan </span>
            </a>

            @elseif(Auth::user()->role === 'pelanggan')
             <a href="{{ route('pelanggan.pesanan') }}" class="position-relative">
               <span> Riwayat Pesanan </span>
               @php
               $cartCount = session('cart_count', 0);
               @endphp
               @if($cartCount > 0)
               <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                 {{ $cartCount }}
               </span>
               @endif
             </a>
            @endif

            <!-- Logout -->
            <a href="{{ route('logout') }}">
              <i class="fa fa-sign-out" aria-hidden="true"></i>
              <span>Logout</span>
            </a>
          @endauth
        </div>
      </nav>
    </div>
  </header>
  <!-- End Header -->

  <!-- Main Content -->
  <main class="py-4 flex-fill">
    @yield('content')
  </main>

  <!-- Footer -->
  <footer class="footer_section text-white py-3 mt-auto">
    <div class="container text-center">
      <p class="mb-0">&copy; <span id="year"></span> Deligo. All rights reserved.</p>
    </div>
  </footer>

  <!-- Scripts -->
  <script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
  <script src="{{ asset('js/bootstrap.js') }}"></script>
  <script>
    document.getElementById('year').textContent = new Date().getFullYear();
  </script>

  <!-- SweetAlert2 Alert -->
  <script>
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: '{{ session('success') }}',
            confirmButtonColor: '#3085d6',
        });
    @endif

    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Gagal',
            text: '{{ session('error') }}',
            confirmButtonColor: '#d33',
        });
    @endif
  </script>
</body>

</html>
