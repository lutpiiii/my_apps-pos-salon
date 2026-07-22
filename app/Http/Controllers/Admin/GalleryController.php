<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Infosalon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index()
    {
        $gallery = Infosalon::orderBy('id_inf', 'desc')->paginate(10);
        return view('admin.salon.gallery', compact('gallery'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul_inf' => 'required|string|max:255',
            'foto_inf' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'keterangan_inf' => 'required|string',
        ]);

        $uploadPath = public_path('assets/uploads');
        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        $fileName = time() . '_' . uniqid() . '.' . $request->foto_inf->extension();
        $request->foto_inf->move($uploadPath, $fileName);

        Infosalon::create([
            'judul_inf' => $request->judul_inf,
            'foto_inf' => $fileName,
            'keterangan_inf' => $request->keterangan_inf,
        ]);

        return redirect()->route('admin.salon.gallery')->with('success', 'Foto galeri berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $item = Infosalon::findOrFail($id);

        $request->validate([
            'judul_inf' => 'required|string|max:255',
            'foto_inf' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'keterangan_inf' => 'required|string',
        ]);

        $data = [
            'judul_inf' => $request->judul_inf,
            'keterangan_inf' => $request->keterangan_inf,
        ];

        if ($request->hasFile('foto_inf')) {
            $uploadPath = public_path('assets/uploads');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            // Delete old photo
            $oldPath = $uploadPath . '/' . $item->foto_inf;
            if (file_exists($oldPath) && is_file($oldPath)) {
                unlink($oldPath);
            }

            $fileName = time() . '_' . uniqid() . '.' . $request->foto_inf->extension();
            $request->foto_inf->move($uploadPath, $fileName);
            $data['foto_inf'] = $fileName;
        }

        $item->update($data);

        return redirect()->route('admin.salon.gallery')->with('success', 'Item galeri berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $item = Infosalon::findOrFail($id);

        $filePath = public_path('assets/uploads/' . $item->foto_inf);
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        $item->delete();

        return redirect()->route('admin.salon.gallery')->with('success', 'Foto galeri berhasil dihapus.');
    }
}
