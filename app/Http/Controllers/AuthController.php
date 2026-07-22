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
        // Jika user sudah login, arahkan langsung sesuai role nya
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->role_p === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif ($user->role_p === 'kasir') {
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

                if ($user->role_p === 'admin') {
                    return redirect()->route('admin.dashboard');
                } elseif ($user->role_p === 'kasir') {
                    return redirect()->route('kasir.dashboard');
                }

                Auth::logout();
                return back()->withErrors(['username_p' => 'Role pengguna tidak dikenali.']);
            }
        }

        return back()->withErrors([
            'username_p' => 'Username atau password salah.',
        ])->onlyInput('username_p');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
