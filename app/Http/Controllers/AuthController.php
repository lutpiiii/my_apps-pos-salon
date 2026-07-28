<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Pengguna;

class AuthController extends Controller
{
    public function showLogin()
    {
        // Jika user sudah login, arahkan langsung ke dashboard sesuai role
        if (Auth::check()) {
            $user = Auth::user();
            $role = strtolower($user->role_p);

            if ($role === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif ($role === 'kasir') {
                return redirect()->route('kasir.dashboard');
            }
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username_p' => ['required', 'string'],
            'password_p' => ['required', 'string'],
        ]);

        $user = Pengguna::where('username_p', $credentials['username_p'])->first();

        if ($user) {
            $isPasswordCorrect = false;
            $dbPassword = $user->password_p;

            // Cek apakah password di DB menggunakan format hash Bcrypt ($2y$)
            if (str_starts_with($dbPassword, '$2y$')) {
                $isPasswordCorrect = Hash::check($credentials['password_p'], $dbPassword);
            } else {
                // Jika bukan Bcrypt (Plain Text dari PHP Native), cek perbandingan langsung
                $isPasswordCorrect = ($credentials['password_p'] === $dbPassword);
            }

            if ($isPasswordCorrect) {
                Auth::login($user);
                $request->session()->regenerate();

                $role = strtolower($user->role_p);

                if ($role === 'admin') {
                    return redirect()->route('admin.dashboard')->with('success_login', 'Selamat Datang Kembali, ' . $user->nama_p . '!');
                } elseif ($role === 'kasir') {
                    return redirect()->route('kasir.dashboard')->with('success_login', 'Selamat Datang Kembali, ' . $user->nama_p . '!');
                }

                Auth::logout();
                return back()->withErrors(['username_p' => 'Role pengguna tidak dikenali.']);
            }
        }

        return back()->with('error_login', 'Username atau password salah.')->onlyInput('username_p');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
