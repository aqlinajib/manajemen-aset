<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Aset;

class AsetController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $perPage = $request->input('per_page', 5);

        $query = Aset::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('kategori', 'like', '%' . $search . '%')
                    ->orWhere('merk', 'like', '%' . $search . '%')
                    ->orWhere('spesifikasi', 'like', '%' . $search . '%');
            });
        }

        $asets = $query->orderBy('created_at', 'desc')->paginate($perPage)->withQueryString();

        return view('aset.index', compact('asets', 'search', 'perPage'));
    }

    public function create()
    {
        return view('aset.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori' => 'required',
            'merk' => 'required',
            'spesifikasi' => 'required',
            'jumlah' => 'required|integer|min:1',
            'tanggal' => 'required|date',
            'status' => 'required',
            'progress' => 'nullable',
        ]);

        Aset::create($request->all());

        return redirect()->route('aset.index')->with('success', 'Aset berhasil ditambahkan!');
    }

    public function show($id)
    {
        $aset = Aset::findOrFail($id);
    
        $transaksis = $aset->transaksis()->orderBy('tanggal')->get();
    
        // Hitung jumlah awal (dengan membalik semua transaksi dari akhir ke awal)
        $jumlahAwal = $aset->jumlah;
        foreach ($transaksis as $trx) {
            if ($trx->status === 'masuk') {
                $jumlahAwal -= $trx->jumlah;
            } elseif ($trx->status === 'keluar') {
                $jumlahAwal += $trx->jumlah;
            }
        }
    
        // Bangun riwayat dari jumlah awal
        $runningTotal = $jumlahAwal;
        $riwayat = [];
    
        foreach ($transaksis as $trx) {
            $jumlah = $trx->status === 'masuk' ? $trx->jumlah : -$trx->jumlah;
            $runningTotal += $jumlah;
            $riwayat[] = [
                'tanggal' => $trx->tanggal,
                'keterangan' => ucfirst($trx->status),
                'jumlah' => $jumlah > 0 ? "+{$jumlah}" : "{$jumlah}",
                'total' => $runningTotal,
            ];
        }
    
        return view('aset.show', compact('aset', 'riwayat'));
    }    

    public function edit(string $id)
    {
        $aset = Aset::findOrFail($id);
        return view('aset.edit', compact('aset'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'kategori' => 'required',
            'merk' => 'required',
            'spesifikasi' => 'required',
            'jumlah' => 'required|integer|min:1',
            'tanggal' => 'required|date',
            'status' => 'required',
            'progress' => 'nullable',
        ]);

        $aset = Aset::findOrFail($id);
        $aset->update($request->all());

        return redirect()->route('aset.index')->with('success', 'Aset berhasil diperbarui!');
    }

    public function destroy(Aset $aset)
    {
        $aset->delete();

        return redirect()->route('aset.index')->with('success', 'Data berhasil dihapus');
    }
}
