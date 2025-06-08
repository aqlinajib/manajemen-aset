@extends('layouts.app')

@section('content')
<div class="py-10 bg-gray-100">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 bg-white shadow-md rounded-lg p-6">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">Tambah Transaksi Barang Masuk/Keluar</h2>

        @if($errors->any())
            <div class="mb-4 p-4 bg-red-100 text-red-700 rounded border border-red-300">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('transaksi-aset.store') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Aset</label>
                <select name="aset_id" class="w-full border-gray-300 rounded p-2" required>
                    <option value="">-- Pilih Aset --</option>
                    @foreach($asets as $aset)
                        <option value="{{ $aset->id }}">
                            {{ $aset->kategori }} | {{ $aset->merk }} | {{ $aset->spesifikasi }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah</label>
                <input type="number" name="jumlah" min="1" class="w-full border-gray-300 rounded p-2" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="status" class="w-full border-gray-300 rounded p-2" required>
                    <option value="">-- Pilih Status --</option>
                    <option value="Masuk">Masuk</option>
                    <option value="Keluar">Keluar</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
                <input type="date" name="tanggal" class="w-full border-gray-300 rounded p-2" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Progress</label>
                <select name="progress" class="w-full border-gray-300 rounded p-2" required>
                    <option value="">-- Pilih Progress --</option>
                    <option value="Done">Done</option>
                    <option value="On Progress">On Progress</option>
                    <option value="Canceled">Canceled</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan (Opsional)</label>
                <textarea name="keterangan" rows="3" class="w-full border-gray-300 rounded p-2"></textarea>
            </div>

            <div class="pt-4">
                <button type="submit" class="bg-black text-white px-6 py-2 rounded hover:bg-gray-800 transition">
                    Simpan Transaksi
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
