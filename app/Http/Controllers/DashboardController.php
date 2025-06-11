<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Aset;
use App\Models\TransaksiAset;

class DashboardController extends Controller
{
    public function index()
    {
        $totalAssets = Aset::count(); // Jumlah semua jenis aset
        $criticalAssets = Aset::where('jumlah', '<=', 9)->get(); // Aset yang jumlahnya <= 9
        $readyAssets = Aset::where('jumlah', '>=', 10)->count(); // Aset yang statusnya 'ready'
        $totalItem = Aset::sum('jumlah'); // Jumlah total dari semua aset

        // Ambil semua aktivitas dari tabel transaksi untuk scroll di frontend
        $recentActivities = TransaksiAset::with('aset')
            ->orderByDesc('tanggal')
            ->get()
            ->map(function ($item) {
                return (object)[
                    'tanggal' => $item->tanggal,
                    'kategori' => $item->aset->kategori ?? '-',
                    'status' => $item->status,
                    'progress' => $item->progress ?? '-',
                ];
            });

        return view('dashboard', compact(
            'totalAssets',
            'criticalAssets',
            'readyAssets',
            'totalItem',
            'recentActivities'
        ));
    }
}