<?php

namespace App\Http\Controllers;

use App\Models\Reservasi;
use App\Models\Detailreservasi;
use App\Models\Menulayanan;
use App\Models\Pengguna;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ReservasiController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_pelanggan' => 'required|string|max:100',
            'notelp_pelanggan' => 'required|string|max:20',
            'email_pelanggan' => 'nullable|email|max:100',
            'id_stylist' => 'nullable|exists:pengguna,id_p',
            'tanggal_reservasi' => 'required|date|after_or_equal:today',
            'jam_reservasi' => 'required',
            'catatan' => 'nullable|string|max:500',
            'items' => 'required|array|min:1',
            'items.*.id_m' => 'required|exists:menulayanan,id_m',
            'items.*.jumlah' => 'nullable|integer|min:1',
        ], [
            'nama_pelanggan.required' => 'Nama lengkap wajib diisi.',
            'notelp_pelanggan.required' => 'Nomor WhatsApp/Telepon wajib diisi.',
            'items.required' => 'Silakan pilih minimal 1 layanan yang diinginkan.',
            'items.min' => 'Silakan pilih minimal 1 layanan yang diinginkan.',
            'tanggal_reservasi.required' => 'Tanggal reservasi wajib dipilih.',
            'tanggal_reservasi.after_or_equal' => 'Tanggal reservasi tidak boleh di masa lalu.',
            'jam_reservasi.required' => 'Jam reservasi wajib dipilih.',
        ]);

        try {
            DB::beginTransaction();

            // Generate unique reservation code RSV-YYYYMMDD-XXXX
            $dateStr = date('Ymd');
            $randomStr = strtoupper(Str::random(4));
            $kodeReservasi = 'RSV-' . $dateStr . '-' . $randomStr;

            $firstItem = $validated['items'][0] ?? null;

            $reservasi = Reservasi::create([
                'kode_reservasi' => $kodeReservasi,
                'nama_pelanggan' => $validated['nama_pelanggan'],
                'notelp_pelanggan' => $validated['notelp_pelanggan'],
                'email_pelanggan' => $validated['email_pelanggan'] ?? null,
                'id_menu' => $firstItem['id_m'] ?? null,
                'id_stylist' => $validated['id_stylist'] ?? null,
                'tanggal_reservasi' => $validated['tanggal_reservasi'],
                'jam_reservasi' => $validated['jam_reservasi'],
                'catatan' => $validated['catatan'] ?? null,
                'status' => 'Menunggu',
            ]);

            $totalSemua = 0;
            $itemsSummary = [];

            foreach ($validated['items'] as $itemData) {
                $menu = Menulayanan::find($itemData['id_m']);
                if ($menu) {
                    $qty = isset($itemData['jumlah']) && $itemData['jumlah'] > 0 ? (int)$itemData['jumlah'] : 1;
                    $harga = $menu->harga_m;
                    $subtotal = $harga * $qty;
                    $totalSemua += $subtotal;

                    Detailreservasi::create([
                        'id_reservasi' => $reservasi->id_r,
                        'id_menu' => $menu->id_m,
                        'harga_saat_ini' => $harga,
                        'jumlah' => $qty,
                    ]);

                    $itemsSummary[] = [
                        'nama' => $menu->nama_m,
                        'harga' => $harga,
                        'harga_formatted' => 'Rp ' . number_format($harga, 0, ',', '.'),
                        'qty' => $qty,
                        'subtotal' => $subtotal,
                        'subtotal_formatted' => 'Rp ' . number_format($subtotal, 0, ',', '.'),
                    ];
                }
            }

            DB::commit();

            $reservasi->load(['stylist']);

            return response()->json([
                'success' => true,
                'message' => 'Reservasi Anda berhasil dikirim! Silakan simpan Kode Reservasi Anda.',
                'data' => [
                    'kode_reservasi' => $reservasi->kode_reservasi,
                    'nama' => $reservasi->nama_pelanggan,
                    'items' => $itemsSummary,
                    'total_harga' => 'Rp ' . number_format($totalSemua, 0, ',', '.'),
                    'stylist' => $reservasi->stylist ? $reservasi->stylist->nama_p : 'Bebas (Siapa Saja)',
                    'tanggal' => date('d F Y', strtotime($reservasi->tanggal_reservasi)),
                    'jam' => date('H:i', strtotime($reservasi->jam_reservasi)),
                    'status' => $reservasi->status,
                ]
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal memproses reservasi: ' . $e->getMessage()
            ], 500);
        }
    }

    public function cekStatus(Request $request)
    {
        $search = $request->query('query');
        if (!$search) {
            return response()->json(['success' => false, 'message' => 'Masukkan Kode Reservasi atau Nomor Telepon.'], 400);
        }

        $reservasi = Reservasi::with(['details.menu', 'menu', 'stylist'])
            ->where('kode_reservasi', $search)
            ->orWhere('notelp_pelanggan', $search)
            ->orderBy('created_at', 'desc')
            ->get();

        if ($reservasi->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'Data reservasi tidak ditemukan.'], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $reservasi->map(function ($item) {
                $itemList = [];
                if ($item->details->count() > 0) {
                    foreach ($item->details as $d) {
                        if ($d->menu) {
                            $itemList[] = $d->menu->nama_m . ($d->jumlah > 1 ? ' (' . $d->jumlah . 'x)' : '') . ' - Rp ' . number_format($d->harga_saat_ini * $d->jumlah, 0, ',', '.');
                        }
                    }
                } elseif ($item->menu) {
                    $itemList[] = $item->menu->nama_m . ' - Rp ' . number_format($item->menu->harga_m, 0, ',', '.');
                }

                return [
                    'kode' => $item->kode_reservasi,
                    'nama' => $item->nama_pelanggan,
                    'layanan_list' => $itemList,
                    'total_harga' => 'Rp ' . number_format($item->total_harga, 0, ',', '.'),
                    'stylist' => $item->stylist ? $item->stylist->nama_p : 'Bebas',
                    'tanggal' => date('d F Y', strtotime($item->tanggal_reservasi)),
                    'jam' => date('H:i', strtotime($item->jam_reservasi)),
                    'status' => $item->status,
                    'catatan_admin' => $item->catatan_admin,
                    'badge' => $item->status_badge,
                ];
            })
        ]);
    }

    public function downloadBukti($id)
    {
        try {
            // Check if ID is a reservation code (RSV-...) or a numeric/encrypted ID
            if (strpos($id, 'RSV-') === 0) {
                $reservasi = Reservasi::with(['details.menu', 'menu'])->where('kode_reservasi', $id)->firstOrFail();
            } elseif (strlen($id) > 20) {
                $originalEncrypted = str_replace(['-', '_'], ['+', '/'], $id);
                $decryptedId = \Illuminate\Support\Facades\Crypt::decryptString($originalEncrypted);
                $reservasi = Reservasi::with(['details.menu', 'menu'])->findOrFail($decryptedId);
            } else {
                $reservasi = Reservasi::with(['details.menu', 'menu'])->findOrFail($id);
            }

            $pdf = Pdf::loadView('reservasi.bukti_pdf', compact('reservasi'));

            return $pdf->download('Bukti_Reservasi_' . $reservasi->kode_reservasi . '.pdf');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengunduh bukti reservasi: ' . $e->getMessage());
        }
    }
}
