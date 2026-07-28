<?php

namespace App\Http\Controllers;

use App\Models\Profilesalon;
use App\Models\Kategorilayanan;
use App\Models\Menulayanan;
use App\Models\Infosalon;
use App\Models\Pengguna;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function index(Request $request)
    {
        // Jika user sudah login, arahkan langsung ke dashboard sesuai role
        if (auth()->check()) {
            $user = auth()->user();
            if (strtolower($user->role_p) === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif (strtolower($user->role_p) === 'kasir') {
                return redirect()->route('kasir.dashboard');
            }
        }

        $profile = Profilesalon::first();
        $informasi = Infosalon::all();
        $categories = Kategorilayanan::where('is_deleted', false)->get();
        $allMenus = Menulayanan::where('is_deleted', false)->orderBy('nama_m', 'asc')->get();
        $stylists = Pengguna::all();

        $selectedCategory = $request->query('id_kategori');

        $query = Menulayanan::where('is_deleted', false);
        if ($selectedCategory) {
            $query->where('id_kategori', $selectedCategory);
        }
        $menus = $query->paginate(8);

        if ($request->ajax()) {
            return response()->json([
                'html' => view('partials.menu_items', compact('menus'))->render(),
                'pagination' => $menus->links('pagination::bootstrap-4')->render()
            ]);
        }

        return view('welcome', compact('profile', 'informasi', 'categories', 'menus', 'selectedCategory', 'allMenus', 'stylists'));
    }
}
