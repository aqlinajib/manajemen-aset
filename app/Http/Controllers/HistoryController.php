<?php

namespace App\Http\Controllers;

use App\Models\TransaksiAsetHistory;
use App\Models\Aset;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function index(Request $request)
    {
        // Ambil semua data history, urutkan berdasarkan created_at
        $histories = TransaksiAsetHistory::with('transaksiAset.aset') // Mengambil relasi transaksi dan aset
            ->orderBy('created_at', 'desc')
            ->paginate(10); // Menampilkan 10 data per halaman, bisa disesuaikan

        return view('history.index', compact('histories'));
    }
}