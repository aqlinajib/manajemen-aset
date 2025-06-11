@extends('layouts.app')

@section('content')
<div class="py-12 bg-gray-100">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white p-6 shadow rounded-xl">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Detail Aset</h2>

            {{-- Detail Informasi Aset --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-700">
                <div><strong>Kategori:</strong> {{ $aset->kategori }}</div>
                <div><strong>Merk:</strong> {{ $aset->merk }}</div>
                <div><strong>Spesifikasi:</strong> {{ $aset->spesifikasi }}</div>
                <div><strong>Jumlah Saat Ini:</strong> {{ $aset->jumlah }}</div>
                <div><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($aset->tanggal)->format('d M Y') }}</div>
                <div><strong>Status:</strong> {{ ucfirst($aset->status) }}</div>
                <div><strong>Progress:</strong> {{ ucfirst($aset->progress) }}</div>
            </div>

          {{-- Riwayat Aset --}}
<div class="mt-8 bg-white p-6 rounded shadow">
    <h3 class="text-lg font-bold mb-4">Riwayat Aset</h3>
    @if(count($riwayat) > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full text-center border border-gray-300">
                <thead class="bg-black text-white">
                    <tr>
                        <th class="p-2 border-r">Tanggal</th>
                        <th class="p-2 border-r">Keterangan</th>
                        <th class="p-2 border-r">Jumlah</th>
                        <th class="p-2">Total</th>
                    </tr>
                </thead>
                <tbody class="text-gray-800 bg-white font-mono">
                    @foreach ($riwayat as $row)
                        <tr class="hover:bg-gray-100">
                            <td class="p-2 border-t border-r">{{ \Carbon\Carbon::parse($row['tanggal'])->format('d M Y') }}</td>
                            <td class="p-2 border-t border-r">
                                <span class="inline-block px-2 py-1 rounded text-xs
                                    {{ $row['status']=='masuk' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                    {{ $row['keterangan'] }}
                                </span>
                            </td>
                            <td class="p-2 border-t border-r font-semibold {{ str_starts_with($row['jumlah'], '+') ? 'text-green-600' : 'text-red-600' }}">
                                {{ $row['jumlah'] }}
                            </td>
                            <td class="p-2 border-t font-semibold">{{ $row['total'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p class="text-gray-500">Belum ada riwayat transaksi untuk aset ini.</p>
    @endif
</div>

            {{-- Tombol Kembali --}}
            <div class="mt-6 flex justify-end">
                <a href="{{ route('aset.index') }}" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded text-sm">← Kembali</a>
            </div>
        </div>
    </div>
</div>
@endsection
