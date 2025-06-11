@extends('layouts.app')

@section('content')
<div class="py-10 bg-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">History Transaksi Aset</h2>

        {{-- Tabel History --}}
        <div class="overflow-x-auto bg-white shadow rounded-lg">
            <table class="min-w-full text-sm text-center table-auto border border-gray-300">
                <thead class="bg-black text-white uppercase tracking-wider">
                    <tr>
                        <th class="p-3 w-32 border-r">Tanggal</th>
                        <th class="p-3 w-40 border-r">Merk</th>
                        <th class="p-3 w-64 border-r">Spesifikasi</th>
                        <th class="p-3 w-40 border-r">Activity</th>
                        <th class="p-3 w-32 border-r">Progress</th>
                        <th class="p-3 w-28">Status</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700 divide-y">
                    @foreach ($histories as $history)
                        <tr class="hover:bg-gray-50">
                            <td class="p-3 border-r">{{ \Carbon\Carbon::parse($history->created_at)->format('d M Y H:i') }}</td>
                            <td class="p-3 border-r">{{ $history->transaksiAset->aset->merk }}</td>
                            <td class="p-3 border-r">{{ $history->transaksiAset->aset->spesifikasi }}</td>
                            <td class="p-3 border-r">{{ $history->activity }}</td>
                            <td class="p-3 border-r">
                                <span class="inline-block px-2 py-1 rounded text-xs 
                                    @if(strtolower($history->progress) == 'done') 
                                        bg-green-100 text-green-700
                                    @elseif(strtolower($history->progress) == 'on progress') 
                                        bg-yellow-100 text-yellow-700
                                    @else 
                                        bg-red-100 text-red-700
                                    @endif
                                ">
                                    {{ $history->progress }}
                                </span>
                            </td>
                            <td class="p-3 border-r">{{ $history->transaksiAset->status }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-4">
            {{ $histories->links() }}
        </div>
    </div>
</div>
@endsection
