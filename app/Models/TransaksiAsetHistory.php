<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransaksiAsetHistory extends Model
{
    protected $fillable = [
    'transaksi_aset_id', 'progress', 'activity', 'user_id'
    ];
    
    public function user() {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
    public function transaksiAset()
    {
    return $this->belongsTo(TransaksiAset::class);
    }

    
}