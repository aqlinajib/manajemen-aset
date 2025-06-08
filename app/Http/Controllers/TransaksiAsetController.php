<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransaksiAset;
use App\Models\Aset;

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

        TransaksiAset::create($request->all());

        return redirect()
        ->route($request->status == 'Masuk' ? 'transaksi.masuk' : 'transaksi.keluar')
        ->with('success', 'Transaksi berhasil dicatat!');
    }

    public function show(string $id)
    {
        $transaksi = TransaksiAset::with('aset')->findOrFail($id);
        return view('transaksi.show', compact('transaksi'));
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
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
