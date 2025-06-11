<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransaksiAset;
use App\Models\Aset;
use Illuminate\Support\Facades\Auth;



class TransaksiAsetController extends Controller
{
    public function index()
    {
        //
    }

    public function masuk(Request $request)
    {
        $query = TransaksiAset::with('aset')->where('status', 'Masuk');
        
        if ($request->has('search')) {
            $search = $request->search;
            $query->whereHas('aset', function ($q) use ($search) {
                $q->where('kategori', 'like', "%$search%")
                  ->orWhere('merk', 'like', "%$search%")
                  ->orWhere('spesifikasi', 'like', "%$search%");
            });
        }

        $perPage = $request->get('per_page', 5);
        $transaksis = $query->orderByDesc('tanggal')->paginate($perPage);

        return view('transaksi.masuk', compact('transaksis'));
    }

    public function keluar(Request $request)
    {
        $query = TransaksiAset::with('aset')->where('status', 'Keluar');

        if ($request->has('search')) {
            $search = $request->search;
            $query->whereHas('aset', function ($q) use ($search) {
                $q->where('kategori', 'like', "%$search%")
                  ->orWhere('merk', 'like', "%$search%")
                  ->orWhere('spesifikasi', 'like', "%$search%");
            });
        }

        $perPage = $request->get('per_page', 5);
        $transaksis = $query->orderByDesc('tanggal')->paginate($perPage);

        return view('transaksi.keluar', compact('transaksis'));
    }

    public function create()
    {
        $asets = Aset::all();
        return view('transaksi.create', compact('asets'));
    }

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

    if ($request->status == 'Masuk') {
        $aset->jumlah += $request->jumlah;
    } else {
        if ($aset->jumlah < $request->jumlah) {
            return back()->withErrors(['jumlah' => 'Stok aset tidak mencukupi!']);
        }
        $aset->jumlah -= $request->jumlah;
    }
    $aset->save();

    $trx = TransaksiAset::create($request->all());

    // Tambah baris ke table history
    \App\Models\TransaksiAsetHistory::create([
        'transaksi_aset_id' => $trx->id,
        'progress' => $request->progress,
        'activity' => 'Filling form',
        'user_id' => Auth::id(), // kalau sudah pasti login

    ]);

    return redirect()
        ->route($request->status == 'Masuk' ? 'transaksi.masuk' : 'transaksi.keluar')
        ->with('success', 'Transaksi berhasil dicatat!');
}

    public function show(string $id)
    {
        $transaksi = TransaksiAset::with(['aset', 'histories.user'])->findOrFail($id);
        // Jika ingin sorted
        $histories = $transaksi->histories->sortBy('created_at')->values();

        return view('transaksi.show', compact('transaksi', 'histories'));
    }

    public function edit($id)
    {
        $trx = TransaksiAset::findOrFail($id);
        return view('transaksi.edit', compact('trx'));
    }
    

    public function update(Request $request, $id)
{
    $request->validate([
        'jumlah' => 'required|integer|min:1',
        'progress' => 'nullable|string',
        'keterangan' => 'nullable|string',
        'tanggal' => 'required|date',
    ]);

    $trx = TransaksiAset::findOrFail($id);
    $aset = Aset::findOrFail($trx->aset_id);

    // Koreksi stok jika jumlah berubah (opsional: bisa tambahkan validasi)
    // ... sesuaikan logika koreksi stok

    // Update transaksi
    $trx->update($request->all());

    // Tambah baris ke history
    \App\Models\TransaksiAsetHistory::create([
        'transaksi_aset_id' => $trx->id,
        'progress' => $request->progress,
        'activity' => 'Edit form',
        'user_id' => Auth::id(), // kalau sudah pasti login
    ]);

    return redirect()
        ->route($trx->status == 'Masuk' ? 'transaksi.masuk' : 'transaksi.keluar')
        ->with('success', 'Transaksi berhasil diupdate!');
}


    public function destroy(string $id)
    {
        $transaksi = TransaksiAset::findOrFail($id);
        $aset = $transaksi->aset;

        if ($aset) {
            if ($transaksi->status == 'Masuk') {
                $aset->jumlah -= $transaksi->jumlah;
                if ($aset->jumlah < 0) $aset->jumlah = 0;
            } else {
                $aset->jumlah += $transaksi->jumlah;
            }
            $aset->save();
        }

        $transaksi->delete();

        return back()->with('success', 'Transaksi berhasil dihapus & stok dikembalikan!');
    }
}