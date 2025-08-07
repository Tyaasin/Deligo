<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Deligo</title>
  <link rel="stylesheet" href="{{ asset('css/css_login-pelanggan.css') }}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
  <div class="main">

    @if (session('success'))
    <div class="alert alert-success mt-2">
      {{ session('success') }}
    </div>
    @endif

    <!-- Register Form -->
    <div class="container a-container is-hidden" id="a-container">
      <form class="form" id="a-form" method="POST" action="{{ route('register.store') }}">
        @csrf
        <h2 class="form_title title">Daftar Akun</h2>

        <input class="form__input" type="text" name="name" placeholder="Name" required value="{{ old('name') }}">
        @error('name') <small style="color: red">{{ $message }}</small> @enderror

        <input class="form__input email" type="email" name="email" placeholder="Email" required value="" autocomplete="off">
        {{-- @error('email') <small style="color: red">{{ $message }}</small> @enderror --}}

        <input class="form__input" type="text" name="no_hp" placeholder="No HP" required pattern="\d{10,}" title="Minimal 10 digit angka" value="{{ old('no_hp') }}" maxlength=13>
        @error('no_hp') <small style="color: red">{{ $message }}</small> @enderror

        <input class="form__input password" type="password" name="password" placeholder="Password" required minlength="6" autocomplete="off">
        @error('password') <small style="color: red">{{ $message }}</small> @enderror

        <button class="form__button button submit" type="submit">Register</button>
      </form>
    </div>

    <!-- Login Form -->
    <div class="container b-container" id="b-container">
      <form class="form" id="b-form" method="POST" action="{{ route('login.store') }}">
        @csrf
        <h2 class="form_title title">Login</h2>

        {{-- Tampilkan error khusus login --}}
        @if (session('login_error'))
        <div class="alert alert-danger mt-2">
          {{ session('login_error') }}
        </div>
        @endif

        <input class="form__input email" name="email" type="email" placeholder="Email" required value="" autocomplete="off">
        <input class="form__input password" name="password" type="password" placeholder="Password" required minlength="6" autocomplete="off">
        <button class="form__button button submit" type="submit">Login</button>
      </form>
    </div>

    <!-- Switch Panel -->
    <div class="switch" id="switch-cnt">
      <div class="switch__circle"></div>
      <div class="switch__circle switch__circle--t"></div>

      <div class="switch__container" id="switch-c1">
        <h2 class="switch__title title">Welcome Back!</h2>
        <p class="switch__description description">Silahkan daftarkan akun anda jika belum punya akun</p>
        <button class="switch__button button switch-btn" id="switch-to-register">Register</button>
      </div>

      <div class="switch__container is-hidden" id="switch-c2">
        <h2 class="switch__title title">Welcome</h2>
        <p class="switch__description description">Silahkan login di sini jika sudah punya akun</p>
        <button class="switch__button button switch-btn" id="switch-to-login">Login</button>
      </div>
    </div>
  </div>

  <script>
    const switchBtnLogin = document.getElementById("switch-to-login");
    const switchBtnRegister = document.getElementById("switch-to-register");
    const aContainer = document.getElementById("a-container");
    const bContainer = document.getElementById("b-container");
    const switchC1 = document.getElementById("switch-c1");
    const switchC2 = document.getElementById("switch-c2");

    function showLogin() {
      aContainer.classList.add("is-hidden");
      bContainer.classList.remove("is-hidden");
      switchC1.classList.remove("is-hidden");
      switchC2.classList.add("is-hidden");
    }

    function showRegister() {
      bContainer.classList.add("is-hidden");
      aContainer.classList.remove("is-hidden");
      switchC1.classList.add("is-hidden");
      switchC2.classList.remove("is-hidden");
      // document.getElementByClassName('email').value = "";
      // document.getElementByClassName('password').value = "";
    }

    switchBtnLogin.addEventListener("click", showLogin);
    switchBtnRegister.addEventListener("click", showRegister);

    window.addEventListener("DOMContentLoaded", () => {
      // Jika error/old pada register, buka register panel
      @if(old('name'))
      showRegister();
      @else
      showLogin();
      @endif
    });

  </script>

  @include('sweetalert::alert')
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>

