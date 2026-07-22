<?php

namespace App\Http\Controllers;

use App\Models\Profilesalon;
use App\Models\Kategorilayanan;
use App\Models\Menulayanan;
use App\Models\Infosalon;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function index(Request $request)
    {
        $profile = Profilesalon::first();
        $informasi = Infosalon::all();
        $categories = Kategorilayanan::where('is_deleted', false)->get();

        $selectedCategory = $request->query('id_kategori');

        $query = Menulayanan::where('is_deleted', false);
        if ($selectedCategory) {
            $query->where('id_kategori', $selectedCategory);
        }
        $menus = $query->take(8)->get();

        if ($request->ajax()) {
            return view('partials.menu_items', compact('menus'))->render();
        }

        return view('welcome', compact('profile', 'informasi', 'categories', 'menus', 'selectedCategory'));
    }
}
