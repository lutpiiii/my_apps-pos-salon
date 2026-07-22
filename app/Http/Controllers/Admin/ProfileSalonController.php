<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Profilesalon;
use Illuminate\Http\Request;

class ProfileSalonController extends Controller
{
    public function index()
    {
        $profile = Profilesalon::first();
        return view('admin.salon.profile', compact('profile'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'nama_prf' => 'required|string|max:255',
            'keterangan_prf' => 'required|string',
            'notelp_prf' => 'required|string|max:20',
            'email_prf' => 'required|email|max:255',
        ]);

        $profile = Profilesalon::first();
        if (!$profile) {
            Profilesalon::create($request->all());
        } else {
            $profile->update($request->all());
        }

        return redirect()->route('admin.salon.profile')->with('success', 'Profil salon berhasil diperbarui.');
    }
}
