@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto py-10">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6">Tambah Data Aset</h2>

        <form action="{{ route('aset.store') }}" method="POST" class="bg-white p-6 rounded-xl shadow space-y-4">
            @csrf

            <div>
                <label for="kategori" class="block text-sm font-medium text-gray-700">Kategori</label>
                <select name="kategori" id="kategori" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">-- Pilih Kategori --</option>
                    <option value="Jok Mobil">Jok Mobil</option>
                    <option value="Jok Motor">Jok Motor</option>
                    <option value="Busa">Busa</option>
                </select>
            </div>

            <div>
                <label for="merk" class="block text-sm font-medium text-gray-700">Merk</label>
                <input type="text" name="merk" id="merk" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
            </div>

            <div>
                <label for="spesifikasi" class="block text-sm font-medium text-gray-700">Spesifikasi</label>
                <textarea name="spesifikasi" id="spesifikasi" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required></textarea>
            </div>

            <div>
                <label for="jumlah" class="block text-sm font-medium text-gray-700">Jumlah</label>
                <input type="number" name="jumlah" id="jumlah" min="1" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
            </div>

            <div>
                <label for="tanggal" class="block text-sm font-medium text-gray-700">Tanggal</label>
                <input type="date" name="tanggal" id="tanggal" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
            </div>

            <div>
                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                    <option value="">-- Pilih Status --</option>
                    <option value="Masuk">Masuk</option>
                    <option value="Keluar">Keluar</option>
                </select>
            </div>

            <div>
                <label for="progress" class="block text-sm font-medium text-gray-700">Progress</label>
                <select name="progress" id="progress" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                    <option value="">-- Pilih Progress --</option>
                    <option value="Done">Done</option>
                    <option value="On Progress">On Progress</option>
                    <option value="Canceled">Canceled</option>
                </select>
            </div>

            <div class="pt-4">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">Simpan</button>
            </div>
        </form>
    </div>
@endsection
