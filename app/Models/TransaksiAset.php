<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiAset extends Model
{
    use HasFactory;

    protected $fillable = [
        'aset_id', 'jumlah', 'status', 'tanggal', 'progress', 'keterangan'
    ];

    public function aset()
    {
        return $this->belongsTo(Aset::class);
    }

    public function show(string $id)
    {
        $transaksi = \App\Models\TransaksiAset::with('aset')->findOrFail($id);
        return view('transaksi.show', compact('transaksi'));
    }
    public function histories()
    {
    return $this->hasMany(TransaksiAsetHistory::class, 'transaksi_aset_id');
    }


}