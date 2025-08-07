<?php
namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Pembayaran;
use App\Models\Pesanan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class AdminAuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function dashboard()
    {
        $data = [
            'userCount'       => User::count(),
            'menuCount'       => Menu::count(),
            'pesananCount'    => Pesanan::count(),
            'pembayaranCount' => Pembayaran::count(),
            'title'           => 'Dashboard',
            'content'         => 'admin.pages',
        ];

        return view('admin.layouts.wrapper', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            Alert::error('Login Gagal', 'Email salah!');
            return back()->withInput();
        }

        if (!Hash::check($request->password, $user->password)) {
            Alert::error('Login Gagal', 'Password salah!');
            return back()->withInput();
        }

        Auth::login($user);
        $request->session()->regenerate();

        Alert::success('Sukses', 'Selamat Datang ' . ucfirst($user->role));

        return match ($user->role) {
            'admin'     => redirect()->route('admin.pages')->with('success', 'Login Berhasil!'),
            'pelanggan' => redirect()->route('pelanggan.pages')->with('success', 'Login Berhasil!'),
            'kasir'     => redirect()->route('kasir.transaksi.index')->with('success', 'Login Berhasil!'),
            default     => tap(Auth::logout(), fn() => back()->with('login_error', 'Role tidak dikenali'))
        };
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            $errorMsg = implode('<br>', $validator->errors()->all());
            \RealRashid\SweetAlert\Facades\Alert::error('Register Gagal', "Email sudah terdaftar");
            return back()->withErrors($validator)->withInput();
        }

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
            'role'     => 'pelanggan'
        ]);

        // Flash alert success untuk ditampilkan di halaman login
        \RealRashid\SweetAlert\Facades\Alert::success('Berhasil', 'Akun berhasil dibuat!');
        return redirect()->route('login');
    }



    public function logout()
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect('login');
    }
}
