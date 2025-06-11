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
        <div class="mt-8 bg-white p-6 rounded shadow">
            <h3 class="text-lg font-bold mb-4">History Perubahan Transaksi</h3>
            @if($histories->count())
                <div class="overflow-x-auto">
                    <table class="min-w-full text-center border border-gray-300">
                        <thead class="bg-black text-white">
                            <tr>
                                <th class="p-2 border-r">Tanggal</th>
                                <th class="p-2 border-r">Progress</th>
                                <th class="p-2 border-r">Aktivitas</th>
                                <th class="p-2">User</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-800 bg-white font-mono">
                            @foreach ($histories as $history)
                                <tr class="hover:bg-gray-100">
                                    <td class="p-2 border-t border-r">{{ \Carbon\Carbon::parse($history->created_at)->format('d M Y H:i') }}</td>
                                    <td class="p-2 border-t border-r">
                                        <span class="inline-block px-2 py-1 rounded text-xs
                                            {{ strtolower($history->progress) == 'done' ? 'bg-green-100 text-green-700' :
                                                (strtolower($history->progress) == 'on progress' ? 'bg-yellow-100 text-yellow-700' :
                                                (strtolower($history->progress) == 'canceled' ? 'bg-red-100 text-red-700' : 'bg-gray-100 text-gray-700')) }}">
                                            {{ $history->progress ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="p-2 border-t border-r">{{ $history->activity ?? '-' }}</td>
                                    <td class="p-2 border-t">{{ $history->user->name ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-gray-500">Belum ada history untuk transaksi ini.</p>
            @endif
        </div>        
        <div class="mt-6">
            <a href="{{ url()->previous() }}" class="bg-gray-300 px-4 py-2 rounded hover:bg-gray-400">← Kembali</a>
        </div>
    </div>
</div>
@endsection
