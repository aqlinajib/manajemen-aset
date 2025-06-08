<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Aset extends Model
{
    use HasFactory;

    protected $fillable = [
        'kategori', 'merk', 'spesifikasi', 'jumlah', 'tanggal', 'status', 'progress'
    ];

    public function transaksis()
    {
        return $this->hasMany(TransaksiAset::class);
    }
}