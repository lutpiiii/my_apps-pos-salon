<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategorilayanan;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = Kategorilayanan::where('is_deleted', false);

        if ($search) {
            $query->where('nama_k', 'LIKE', "%{$search}%");
        }

        $kategori = $query->paginate(10);
        return view('admin.kategori.index', compact('kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_k' => 'required|string|max:255',
        ]);

        Kategorilayanan::create([
            'nama_k' => $request->nama_k,
            'is_deleted' => false,
        ]);

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_k' => 'required|string|max:255',
        ]);

        $kategori = Kategorilayanan::findOrFail($id);
        $kategori->update([
            'nama_k' => $request->nama_k,
        ]);

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $kategori = Kategorilayanan::findOrFail($id);
        $kategori->update(['is_deleted' => true]);

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
