<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PenggunaController extends Controller
{
    public function index()
    {
        $pengguna = Pengguna::paginate(10);
        return view('admin.pengguna.index', compact('pengguna'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_p' => 'required|string|max:255',
            'username_p' => 'required|string|max:255|unique:pengguna,username_p',
            'password_p' => 'required|string|min:4',
            'role_p' => 'required|in:admin,kasir',
            'foto_p' => 'nullable|image|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('foto_p')) {
            $uploadPath = public_path('assets/uploads');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            $fileName = time() . '_user_' . uniqid() . '.' . $request->foto_p->extension();
            $request->foto_p->move($uploadPath, $fileName);
            $data['foto_p'] = $fileName;
        }

        Pengguna::create($data);

        return redirect()->route('admin.pengguna.index')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $pengguna = Pengguna::findOrFail($id);

        $request->validate([
            'nama_p' => 'required|string|max:255',
            'username_p' => 'required|string|max:255|unique:pengguna,username_p,' . $id . ',id_p',
            'role_p' => 'required|in:admin,kasir',
            'foto_p' => 'nullable|image|max:2048',
        ]);

        $data = $request->except(['password_p']);

        if ($request->filled('password_p')) {
            $data['password_p'] = $request->password_p; // Setter handles hashing
        }

        if ($request->hasFile('foto_p')) {
            $uploadPath = public_path('assets/uploads');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            // Delete old photo
            if ($pengguna->foto_p) {
                $oldPath = $uploadPath . '/' . $pengguna->foto_p;
                if (file_exists($oldPath) && is_file($oldPath)) {
                    unlink($oldPath);
                }
            }

            $fileName = time() . '_user_' . uniqid() . '.' . $request->foto_p->extension();
            $request->foto_p->move($uploadPath, $fileName);
            $data['foto_p'] = $fileName;
        }

        $pengguna->update($data);

        return redirect()->route('admin.pengguna.index')->with('success', 'Pengguna berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $pengguna = Pengguna::findOrFail($id);

        if ($pengguna->foto_p && file_exists(public_path('assets/uploads/' . $pengguna->foto_p))) {
            unlink(public_path('assets/uploads/' . $pengguna->foto_p));
        }

        $pengguna->delete();

        return redirect()->route('admin.pengguna.index')->with('success', 'Pengguna berhasil dihapus.');
    }
}
