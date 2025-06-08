<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransaksiAset;

class AktivitasController extends Controller
{
    public function index(Request $request)
    {
        $query = TransaksiAset::with('aset')->orderByDesc('tanggal');

        // Fitur pencarian berdasarkan kategori/merk/spesifikasi
        if ($search = $request->input('search')) {
            $query->whereHas('aset', function ($q) use ($search) {
                $q->where('kategori', 'like', "%{$search}%")
                  ->orWhere('merk', 'like', "%{$search}%")
                  ->orWhere('spesifikasi', 'like', "%{$search}%");
            });
        }

        $transaksis = $query->paginate($request->input('per_page', 5));

        return view('aktivitas.index', compact('transaksis'));
    }
}
