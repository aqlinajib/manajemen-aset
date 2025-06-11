@extends('layouts.app')

@section('content')
<div class="py-12 bg-gray-100">
    <div class="max-w-3xl mx-auto bg-white p-8 shadow rounded">
        <h2 class="text-2xl font-bold mb-6">Edit Transaksi Aset</h2>
        <form action="{{ route('transaksi-aset.update', $trx->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block mb-1">Aset</label>
                <input type="text" value="{{ $trx->aset->kategori ?? '-' }} - {{ $trx->aset->merk ?? '-' }}" 
                    class="w-full border-gray-300 rounded p-2 bg-gray-100" readonly>
            </div>

            <div class="mb-4">
                <label class="block mb-1">Jumlah</label>
                <input type="number" name="jumlah" class="w-full border-gray-300 rounded p-2" min="1"
                    value="{{ old('jumlah', $trx->jumlah) }}" required>
            </div>

            <div class="mb-4">
                <label class="block mb-1">Status</label>
                <select name="status" class="w-full border-gray-300 rounded p-2" required>
                    <option value="Masuk" {{ $trx->status == 'Masuk' ? 'selected' : '' }}>Masuk</option>
                    <option value="Keluar" {{ $trx->status == 'Keluar' ? 'selected' : '' }}>Keluar</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="block mb-1">Tanggal</label>
                <input type="date" name="tanggal" class="w-full border-gray-300 rounded p-2"
                    value="{{ old('tanggal', $trx->tanggal ? \Carbon\Carbon::parse($trx->tanggal)->format('Y-m-d') : '') }}" required>
            </div>

            <div class="mb-4">
                <label class="block mb-1">Progress</label>
                <select name="progress" class="w-full border-gray-300 rounded p-2">
                    <option value="">-- Pilih Progress --</option>
                    <option value="Done" {{ strtolower($trx->progress) == 'done' ? 'selected' : '' }}>Done</option>
                    <option value="On Progress" {{ strtolower($trx->progress) == 'on progress' ? 'selected' : '' }}>On Progress</option>
                    <option value="Canceled" {{ strtolower($trx->progress) == 'canceled' ? 'selected' : '' }}>Canceled</option>
                </select>
            </div>

            <div class="mb-6">
                <label class="block mb-1">Keterangan</label>
                <textarea name="keterangan" class="w-full border-gray-300 rounded p-2" rows="2">{{ old('keterangan', $trx->keterangan) }}</textarea>
            </div>

            {{-- Tombol Kembali dan Update --}}
            <div class="flex justify-between items-center">
                <a href="{{ route('transaksi.masuk') }}" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded text-sm">&larr; Kembali</a>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Update</button>
            </div>
        </form>
    </div>
</div>
@endsection
