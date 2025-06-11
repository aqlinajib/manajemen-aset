<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Aset;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class AsetController extends Controller
{
    public function import(Request $request)
    {
        // Validate uploaded file
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);
    
        // Get the uploaded file
        $file = $request->file('file');
    
        // Load the spreadsheet file
        $spreadsheet = IOFactory::load($file);
    
        // Get the first sheet
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray();
    
        // Loop through the rows to insert or update data in Aset
        foreach ($rows as $key => $row) {
            // Skip header (if present)
            if ($key == 0) {
                continue;
            }
    
            // Convert date from 'd/m/Y' to 'Y-m-d' format
            $tanggal = Carbon::createFromFormat('d/m/Y', $row[4])->format('Y-m-d'); // E1: Tanggal
    
            // Check if asset with the same merk and spesifikasi exists
            $existingAset = Aset::where('merk', $row[0]) // A1: Merk
                                ->where('spesifikasi', $row[1]) // B1: Spesifikasi
                                ->first();
    
            // If it exists, update the quantity
            if ($existingAset) {
                $existingAset->jumlah += $row[2]; // C1: Jumlah
                $existingAset->save(); // Save updated data
            } else {
                // If not, create new asset entry
                Aset::create([
                    'merk' => $row[0], // A1: Merk
                    'spesifikasi' => $row[1], // B1: Spesifikasi
                    'jumlah' => $row[2], // C1: Jumlah
                    'kategori' => $row[3], // D1: Kategori
                    'tanggal' => $tanggal, // E1: Tanggal
                    'status' => $row[5], // F1: Status
                    'progress' => $row[6], // G1: Progress
                ]);
            }
        }
    
        return redirect()->route('aset.index')->with('success', 'Aset berhasil diimpor!');
    }
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
    
        // Ambil semua transaksi untuk aset ini, urut dari tanggal paling lama ke paling baru
        $transaksis = $aset->transaksis()->orderBy('tanggal', 'asc')->get();
    
        // Mulai dari jumlah saat ini (yang tercatat di table asets)
        $jumlahAkhir = $aset->jumlah;
    
        // Hitung jumlah awal dengan mengembalikan efek seluruh transaksi (waktu mundur)
        $jumlahAwal = $jumlahAkhir;
        for ($i = count($transaksis) - 1; $i >= 0; $i--) {
            $trx = $transaksis[$i];
            $status = strtolower($trx->status); // fix case sensitivity!
            if ($status === 'masuk') {
                $jumlahAwal -= $trx->jumlah;
            } elseif ($status === 'keluar') {
                $jumlahAwal += $trx->jumlah;
            }
        }
    
        // Bangun riwayat dari jumlah awal, jalankan efek transaksi ke depan
        $runningTotal = $jumlahAwal;
        $riwayat = [];
        foreach ($transaksis as $trx) {
            $status = strtolower($trx->status); // fix case sensitivity!
            $jumlah = $status === 'masuk' ? $trx->jumlah : -$trx->jumlah;
            $runningTotal += $jumlah;
            $riwayat[] = [
                'tanggal'     => $trx->tanggal,
                'keterangan'  => $status === 'masuk' ? 'Masuk (Ditambah)' : 'Keluar (Dikurang)',
                'jumlah'      => $jumlah > 0 ? "+{$jumlah}" : "{$jumlah}",
                'status'      => $status, // untuk badge di blade
                'total'       => $runningTotal,
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