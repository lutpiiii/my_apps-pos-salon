<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('profile.index', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'nama_p' => 'required|string|max:255',
            'username_p' => 'required|string|max:255|unique:pengguna,username_p,' . $user->id_p . ',id_p',
            'password_p' => 'nullable|string|min:4',
            'foto_p' => 'nullable|image|max:2048',
        ]);

        $data = [
            'nama_p' => $request->nama_p,
            'username_p' => $request->username_p,
        ];

        if ($request->filled('password_p')) {
            $data['password_p'] = $request->password_p; // Setter handles hashing
        }

        if ($request->hasFile('foto_p')) {
            $uploadPath = base_path('public/assets/uploads');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            // Delete old photo
            if ($user->foto_p) {
                $oldPath = $uploadPath . DIRECTORY_SEPARATOR . $user->foto_p;
                if (file_exists($oldPath) && is_file($oldPath)) {
                    unlink($oldPath);
                }
            }

            $fileName = time() . '_profile_' . uniqid() . '.' . $request->foto_p->extension();
            $request->foto_p->move($uploadPath, $fileName);
            $data['foto_p'] = $fileName;
        }

        // We use Pengguna model to update to ensure attributes/setters are called correctly if needed
        Pengguna::where('id_p', $user->id_p)->update($data);

        return redirect()->back()->with('success', 'Profil Anda berhasil diperbarui.');
    }
}
