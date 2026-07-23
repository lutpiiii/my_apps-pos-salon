<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menulayanan;
use App\Models\Kategorilayanan;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $id_kategori = $request->input('id_kategori');
        $query = Menulayanan::with('kategori')->where('is_deleted', false);

        if ($search) {
            $query->where('nama_m', 'LIKE', "%{$search}%");
        }

        if ($id_kategori) {
            $query->where('id_kategori', $id_kategori);
        }

        $menus = $query->paginate(12);
        $categories = Kategorilayanan::where('is_deleted', false)->get();
        return view('admin.menu.index', compact('menus', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_kategori' => 'required|exists:kategorilayanan,id_k',
            'nama_m' => 'required|string|max:255',
            'harga_m' => 'required|numeric|min:0',
        ]);

        Menulayanan::create([
            'id_kategori' => $request->id_kategori,
            'nama_m' => $request->nama_m,
            'harga_m' => $request->harga_m,
            'is_deleted' => false,
        ]);

        return redirect()->route('admin.menu.index')->with('success', 'Menu berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_kategori' => 'required|exists:kategorilayanan,id_k',
            'nama_m' => 'required|string|max:255',
            'harga_m' => 'required|numeric|min:0',
        ]);

        $menu = Menulayanan::findOrFail($id);
        $menu->update([
            'id_kategori' => $request->id_kategori,
            'nama_m' => $request->nama_m,
            'harga_m' => $request->harga_m,
        ]);

        return redirect()->route('admin.menu.index')->with('success', 'Menu berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $menu = Menulayanan::findOrFail($id);
        $menu->update(['is_deleted' => true]);

        return redirect()->route('admin.menu.index')->with('success', 'Menu berhasil dihapus.');
    }
}
