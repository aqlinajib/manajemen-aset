@extends('layouts.app')

@section('content')
<div x-data="{ showModal: false }" class="py-10 bg-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Header --}}
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Data Aset</h2>
        </div>

        {{-- Filter + Tambah Aset --}}
        <div class="flex flex-wrap sm:flex-nowrap justify-between items-center gap-3 mb-4">
            {{-- Form Search --}}
            <form method="GET" class="flex flex-wrap sm:flex-nowrap items-center gap-3 flex-grow">
                <input type="text" name="search" value="{{ request('search') }}"
                    class="px-3 py-1.5 text-sm border border-gray-300 rounded w-full sm:w-64"
                    placeholder="Cari aset...">
                <div class="flex items-center space-x-2">
                    <label for="per_page" class="text-sm whitespace-nowrap">Tampilkan</label>
                    <select name="per_page" id="per_page" onchange="this.form.submit()"
                            class="w-24 px-3 py-2 border border-gray-300 rounded text-sm">
                        <option value="5" {{ request('per_page') == 5 ? 'selected' : '' }}>5</option>
                        <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                        <option value="15" {{ request('per_page') == 15 ? 'selected' : '' }}>15</option>
                    </select>
                    <span class="text-sm">data</span>
                </div>
                <button type="submit"
                        class="px-3 py-1.5 text-sm bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                    Cari
                </button>
            </form>

            {{-- Tombol Tambah Aset --}}
            <a href="{{ route('aset.create') }}"
                class="px-3 py-1.5 text-sm bg-black text-white rounded hover:bg-gray-800 transition">
                + Tambah Aset
            </a>

            {{-- Tombol Import --}}            
            <button @click="showModal = true" class="px-3 py-1.5 text-sm bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                Import Aset
            </button>
        </div>

        {{-- Table Responsive --}}
        <div class="w-full bg-white shadow rounded-lg overflow-x-auto">
            <table class="min-w-full text-sm text-center table-auto border border-gray-300">
                <thead class="bg-black text-white uppercase tracking-wider">
                    <tr>
                        <th class="p-3 w-10 border-r">No</th>
                        <th class="p-3 w-32 border-r">Kategori</th>
                        <th class="p-3 w-40 border-r">Merk</th>
                        <th class="p-3 w-64 border-r">Spesifikasi</th>
                        <th class="p-3 w-20 border-r">Jumlah</th>
                        <th class="p-3 w-28 border-r">Status</th>
                        <th class="p-3 w-28">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700 divide-y">
                    @forelse ($asets as $aset)
                        <tr class="hover:bg-gray-50">
                            <td class="p-3 border-r">{{ $loop->iteration + ($asets->currentPage() - 1) * $asets->perPage() }}</td>
                            <td class="p-3 border-r break-words">{{ $aset->kategori }}</td>
                            <td class="p-3 border-r break-words max-w-[150px]">{{ $aset->merk }}</td>
                            <td class="p-3 border-r break-words max-w-[240px]">{{ $aset->spesifikasi }}</td>
                            <td class="p-3 border-r">{{ $aset->jumlah }}</td>
                            <td class="p-3 border-r">{{ $aset->status }}</td>
                            <td class="p-3 flex flex-col sm:flex-row justify-center gap-2 items-center border-0">
                                <a href="{{ route('aset.show', $aset->id) }}"
                                   class="px-3 py-1 text-sm bg-green-500 text-white rounded hover:bg-green-600 transition w-full sm:w-auto mb-1 sm:mb-0">
                                    Lihat
                                </a>
                                <a href="{{ route('aset.edit', $aset->id) }}"
                                   class="px-3 py-1 text-sm bg-yellow-400 text-gray-900 rounded hover:bg-yellow-500 transition w-full sm:w-auto mb-1 sm:mb-0">
                                    Edit
                                </a>
                                <button @click="showModal = true; selectedId = {{ $aset->id }} "
                                        class="px-3 py-1 text-sm bg-red-500 text-white rounded hover:bg-red-600 transition w-full sm:w-auto">
                                    Hapus
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="p-4 text-center text-gray-500">Tidak ada data aset.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-4">
            {{ $asets->appends(request()->query())->links() }}
        </div>

        {{-- Modal Upload Import --}}
        <div x-cloak x-show="showModal" x-transition
            class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-40 z-50">
            <div class="bg-white p-6 rounded shadow-md max-w-sm w-full">
                <h2 class="text-lg font-semibold mb-4 text-gray-800">Import Aset (Excel/CSV)</h2>
                <form action="{{ route('aset.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <label class="block mb-1">Pilih File Excel (XLSX/CSV)</label>
                        <input type="file" name="file" class="form-control" required>
                    </div>
                    <div class="flex justify-between items-center space-x-3">
                        <button @click="showModal = false" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
                            Batal
                        </button>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                            Upload
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection
