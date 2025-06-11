@extends('layouts.app')

@section('content')
    {{-- Header section tetap --}}


    <div class="py-12 bg-gray-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- ✅ Summary Cards --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-blue-100 text-gray-900 p-6 rounded-xl shadow text-center">
                    <p class="text-base font-semibold">TOTAL ASSETS</p>
                    <h2 class="text-2xl font-bold">{{ $totalAssets }}</h2>
                </div>
                <div class="bg-red-200 text-gray-900 p-6 rounded-xl text-center">
                    <p class="text-base font-semibold">CRITICAL ITEMS</p>
                    <h2 class="text-2xl font-bold">{{ $criticalAssets->count() }}</h2>
                </div>
                <div class="bg-green-200 text-gray-900 p-6 rounded-xl text-center">
                    <p class="text-base font-semibold">ITEMS READY</p>
                    <h2 class="text-2xl font-bold">{{ $readyAssets }}</h2>
                </div>
                <div class="bg-yellow-200 text-gray-900 p-6 rounded-xl text-center">
                    <p class="text-base font-semibold">TOTAL ITEM QUANTITY</p>
                    <h2 class="text-2xl font-bold">{{ $totalItem }}</h2>
                </div>
            </div>

            {{-- 🛑 Critical Assets Table --}}
            <div class="bg-white p-6 rounded-xl shadow">
                <h3 class="font-bold mb-4">Critical Assets (≤ 10 items)</h3>
                <div class="max-h-72 overflow-y-auto rounded-lg border border-gray-300">
                    <table class="min-w-full text-center">
                        <thead class="bg-black text-white sticky top-0">
                            <tr>
                                <th class="p-3 border-r">Kategori</th>
                                <th class="p-3 border-r">Merk</th>
                                <th class="p-3 border-r">Spesifikasi</th>
                                <th class="p-3">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-800 bg-white">
                            @forelse ($criticalAssets as $aset)
                                <tr class="hover:bg-gray-100">
                                    <td class="p-3 border-t border-r">{{ $aset->kategori }}</td>
                                    <td class="p-3 border-t border-r">{{ $aset->merk }}</td>
                                    <td class="p-3 border-t border-r">{{ $aset->spesifikasi }}</td>
                                    <td class="p-3 border-t text-red-600 font-bold">{{ $aset->jumlah }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="p-3 text-center text-gray-500">Tidak ada aset kritis</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- 🔁 Recently Activities Table --}}
            <div class="bg-white p-6 rounded-xl shadow overflow-x-auto">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="font-bold">Recently Activities</h3>
                    <a href="{{ route('aktivitas.index') }}" class="text-sm text-blue-500 font-semibold">View All</a>
                </div>

                {{-- Scrollable content --}}
                <div class="max-h-80 overflow-y-auto rounded-lg border border-gray-300">
                    <table class="min-w-full text-center">
                        <thead class="bg-black text-white sticky top-0">
                            <tr>
                                <th class="p-3 border-r">Tanggal</th>
                                <th class="p-3 border-r">Kategori</th>
                                <th class="p-3 border-r">Status</th>
                                <th class="p-3">Progress</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-800 bg-white">
                            @forelse ($recentActivities as $item)
                                <tr class="hover:bg-gray-100">
                                    <td class="p-3 border-t border-r">{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</td>
                                    <td class="p-3 border-t border-r">{{ $item->kategori }}</td>
                                    <td class="p-3 border-t border-r">{{ ucfirst($item->status) }}</td>
                                    <td class="p-3 border-t">{{ $item->progress }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="p-3 text-center text-gray-500">Belum ada aktivitas terbaru</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
@endsection
