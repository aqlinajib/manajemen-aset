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
}