@extends('layouts.app')

@section('content')
<div class="py-10 bg-gray-100">
    <div class="max-w-4xl mx-auto bg-white shadow p-6 rounded-lg">
        <h2 class="text-2xl font-bold mb-4">Detail Transaksi</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-700">
            <div><strong>Kategori:</strong> {{ $transaksi->aset->kategori }}</div>
            <div><strong>Merk:</strong> {{ $transaksi->aset->merk }}</div>
            <div><strong>Spesifikasi:</strong> {{ $transaksi->aset->spesifikasi }}</div>
            <div><strong>Jumlah:</strong> {{ $transaksi->jumlah }}</div>
            <div><strong>Status:</strong> {{ $transaksi->status }}</div>
            <div><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($transaksi->tanggal)->format('d M Y') }}</div>
            <div><strong>Progress:</strong> {{ ucfirst($transaksi->progress) }}</div>
            <div><strong>Keterangan:</strong> {{ $transaksi->keterangan ?? '-' }}</div>
        </div>

        <div class="mt-6">
            <a href="{{ url()->previous() }}" class="bg-gray-300 px-4 py-2 rounded hover:bg-gray-400">← Kembali</a>
        </div>
    </div>
</div>
@endsection
