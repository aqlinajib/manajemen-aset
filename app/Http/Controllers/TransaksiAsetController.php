<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransaksiAset;
use App\Models\Aset;


class TransaksiAsetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }
    
    public function masuk()
    {
    $transaksis = \App\Models\TransaksiAset::with('aset')->where('status', 'Masuk')->orderByDesc('tanggal')->get();
    return view('transaksi.masuk', compact('transaksis'));
    }

    public function keluar()
    {
        $transaksis = \App\Models\TransaksiAset::with('aset')->where('status', 'Keluar')->orderByDesc('tanggal')->get();
        return view('transaksi.keluar', compact('transaksis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $asets = Aset::all();
        return view('transaksi.create', compact('asets'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'aset_id' => 'required|exists:asets,id',
            'jumlah' => 'required|integer|min:1',
            'status' => 'required|in:Masuk,Keluar',
            'tanggal' => 'required|date',
            'progress' => 'nullable|string',
            'keterangan' => 'nullable|string',
        ]);
    
        $aset = Aset::findOrFail($request->aset_id);
    
        // Logika update jumlah
        if ($request->status == 'Masuk') {
            $aset->jumlah += $request->jumlah;
        } else {
            // Pastikan stok cukup
            if ($aset->jumlah < $request->jumlah) {
                return back()->withErrors(['jumlah' => 'Stok aset tidak mencukupi!']);
            }
            $aset->jumlah -= $request->jumlah;
        }
        $aset->save();
    
        // Simpan transaksi
        \App\Models\TransaksiAset::create($request->all());
    
        return redirect()->route('transaksi.masuk')->with('success', 'Transaksi berhasil dicatat!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
    // Temukan transaksi
    $transaksi = TransaksiAset::findOrFail($id);
    $aset = $transaksi->aset; // Relasi aset

    if ($aset) {
        // Logika rollback jumlah
        if ($transaksi->status == 'Masuk') {
            // Dulu bertambah, sekarang dikurangi
            $aset->jumlah -= $transaksi->jumlah;
            if ($aset->jumlah < 0) $aset->jumlah = 0; // Prevent minus, optional
        } else {
            // Dulu berkurang, sekarang ditambah lagi
            $aset->jumlah += $transaksi->jumlah;
        }
        $aset->save();
    }

    // Hapus transaksi
    $transaksi->delete();

    return back()->with('success', 'Transaksi berhasil dihapus & stok dikembalikan!');
    }
}