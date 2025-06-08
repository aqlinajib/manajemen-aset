@extends('layouts.app')

@section('content')
<div class="py-12 bg-gray-100">
    <div class="max-w-3xl mx-auto bg-white p-8 shadow rounded">
        <h2 class="text-2xl font-bold mb-6">Edit Data Aset</h2>
        <form action="{{ route('aset.update', $aset->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block mb-1">Kategori</label>
                <select name="kategori" class="w-full border-gray-300 rounded p-2" required>
                    <option value="">-- Pilih Kategori --</option>
                    <option value="jok mobil" {{ strtolower($aset->kategori) == 'jok mobil' ? 'selected' : '' }}>Jok Mobil</option>
                    <option value="jok motor" {{ strtolower($aset->kategori) == 'jok motor' ? 'selected' : '' }}>Jok Motor</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="block mb-1">Merk</label>
                <input type="text" name="merk" class="w-full border-gray-300 rounded p-2" value="{{ old('merk', $aset->merk) }}" required>
            </div>

            <div class="mb-4">
                <label class="block mb-1">Spesifikasi</label>
                <textarea name="spesifikasi" class="w-full border-gray-300 rounded p-2" required>{{ old('spesifikasi', $aset->spesifikasi) }}</textarea>
            </div>

            <div class="mb-4">
                <label class="block mb-1">Jumlah</label>
                <input type="number" name="jumlah" class="w-full border-gray-300 rounded p-2" min="1" value="{{ old('jumlah', $aset->jumlah) }}" required>
            </div>

            <div class="mb-4">
                <label class="block mb-1">Tanggal</label>
                <input type="date" name="tanggal" class="w-full border-gray-300 rounded p-2" value="{{ old('tanggal', $aset->tanggal) }}" required>
            </div>

            <div class="mb-4">
                <label class="block mb-1">Status</label>
                <select name="status" class="w-full border-gray-300 rounded p-2" required>
                    <option value="ready" {{ strtolower($aset->status) == 'ready' ? 'selected' : '' }}>Ready</option>
                    <option value="not ready" {{ strtolower($aset->status) == 'not ready' ? 'selected' : '' }}>Not Ready</option>
                </select>
            </div>

            <div class="mb-6">
                <label class="block mb-1">Progress</label>
                <select name="progress" class="w-full border-gray-300 rounded p-2">
                    <option value="">-- Pilih Progress --</option>
                    <option value="done" {{ strtolower($aset->progress) == 'done' ? 'selected' : '' }}>Done</option>
                    <option value="on progress" {{ strtolower($aset->progress) == 'on progress' ? 'selected' : '' }}>On Progress</option>
                    <option value="canceled" {{ strtolower($aset->progress) == 'canceled' ? 'selected' : '' }}>Canceled</option>
                </select>
            </div>

            {{-- Tombol Kembali dan Update --}}
            <div class="flex justify-between items-center">
                <a href="{{ route('aset.index') }}" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded text-sm">&larr; Kembali</a>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Update</button>
            </div>
        </form>
    </div>
</div>
@endsection
