@extends('layouts.app')

@section('content')
<div class="py-10 bg-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <h2 class="text-2xl font-bold text-gray-800 mb-6">Semua Aktivitas Transaksi</h2>

        {{-- Search & Filter --}}
        <form method="GET" class="flex flex-wrap sm:flex-nowrap items-center gap-4 mb-6">
            {{-- Input Search --}}
            <input type="text" name="search" value="{{ request('search') }}"
                class="px-4 py-2 border border-gray-300 rounded w-full sm:w-72 text-sm"
                placeholder="Cari kategori / merk / spesifikasi">

            {{-- Dropdown jumlah data --}}
            <div class="flex items-center gap-2">
                <label for="per_page" class="text-sm">Tampilkan</label>
                <select name="per_page" id="per_page" onchange="this.form.submit()"
                        class="px-3 py-2 border border-gray-300 rounded text-sm w-24">
                    <option value="5" {{ request('per_page') == 5 ? 'selected' : '' }}>5</option>
                    <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                    <option value="15" {{ request('per_page') == 15 ? 'selected' : '' }}>15</option>
                </select>
                <span class="text-sm">data</span>
            </div>

            {{-- Tombol Submit --}}
            <button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm transition">
                Cari
            </button>
        </form>

        {{-- Tabel Aktivitas --}}
        <div class="bg-white rounded-lg shadow overflow-x-auto">
        <table class="min-w-full text-center border border-gray-300">
            <thead class="bg-black text-white">
                <tr>
                    <th class="p-2 border-r">No</th>
                    <th class="p-2 border-r">Tanggal</th>
                    <th class="p-2 border-r">Kategori</th>
                    <th class="p-2 border-r">Merk</th>
                    <th class="p-2 border-r">Spesifikasi</th>
                    <th class="p-2 border-r">Status</th>
                    <th class="p-2">Progress</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($transaksis as $trx)
                    <tr class="hover:bg-gray-100">
                        <td class="p-2 border-t border-r">{{ $loop->iteration + ($transaksis->currentPage() - 1) * $transaksis->perPage() }}</td>
                        <td class="p-2 border-t border-r">{{ \Carbon\Carbon::parse($trx->tanggal)->format('d M Y') }}</td>
                        <td class="p-2 border-t border-r">{{ $trx->aset->kategori ?? '-' }}</td>
                        <td class="p-2 border-t border-r">{{ $trx->aset->merk ?? '-' }}</td>
                        <td class="p-2 border-t border-r">{{ $trx->aset->spesifikasi ?? '-' }}</td>
                        <td class="p-2 border-t border-r">{{ $trx->status }}</td>
                        <td class="p-2 border-t">{{ $trx->progress ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="p-4 text-center text-gray-500">Tidak ada aktivitas ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-4">
            {{ $transaksis->appends(request()->query())->links() }}
        </div>

    </div>
</div>
@endsection
