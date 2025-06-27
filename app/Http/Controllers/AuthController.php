<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User; // Pastikan namespace Model User Anda benar
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class AuthController extends Controller
{

    /**
     * AuthController constructor.
     * Middleware 'guest' diterapkan pada semua method kecuali 'logout'.
     * Ini berarti pengguna yang sudah login tidak bisa mengakses halaman login/register.
     */
    // public function __construct()
    // {
    //     $this->middleware('guest')->except('logout');
    // }

    // --- REGISTRASI PENGGUNA ---

    /**
     * Menampilkan halaman/form registrasi.
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm()
    {
        // Anda perlu membuat view 'auth.register.blade.php'
        return view('auth.register'); 
    }

    /**
     * Memproses data dari form registrasi dan membuat user baru.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(Request $request)
    {
        // Validasi input dari form
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:haura_users'], // 'unique' pada tabel haura_users
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Membuat user baru di database
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'pasien', // Default role untuk setiap user yang mendaftar
        ]);

        // Langsung login-kan user yang baru mendaftar
        Auth::login($user);

        // Arahkan ke halaman dashboard setelah berhasil mendaftar dan login
        return redirect('/dashboard');
    }


    // --- LOGIN PENGGUNA ---

    /**
     * Menampilkan halaman/form login.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Memproses data dari form login untuk otentikasi.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        // Validasi input email dan password
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Mencoba untuk melakukan otentikasi (login)
        // Parameter kedua adalah untuk fitur "Remember Me"
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            // Jika berhasil, arahkan ke halaman yang dituju sebelumnya atau ke dashboard
            return redirect()->intended('dashboard'); 
        }

        // Jika otentikasi gagal, kembali ke halaman login dengan pesan error
        return back()->withErrors([
            'email' => 'Email atau Password yang Anda masukkan salah.',
        ])->onlyInput('email');
    }


    // --- LOGOUT PENGGUNA ---

    /**
     * Mengeluarkan pengguna dari sistem (logout).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::logout();

        // Invalidate session untuk keamanan
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Arahkan ke halaman utama setelah logout
        return redirect('/');
    }
}
