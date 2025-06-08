@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Transaksi Barang Masuk</h2>
    <a href="{{ route('transaksi-aset.create') }}" class="btn btn-primary mb-3">+ Tambah Transaksi</a>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Aset</th>
                    <th>Kategori</th>
                    <th>Merk</th>
                    <th>Spesifikasi</th>
                    <th>Jumlah</th>
                    <th>Tanggal</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transaksis as $trx)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $trx->aset ? $trx->aset->id : '-' }}</td>
                        <td>{{ $trx->aset ? $trx->aset->kategori : '-' }}</td>
                        <td>{{ $trx->aset ? $trx->aset->merk : '-' }}</td>
                        <td>{{ $trx->aset ? $trx->aset->spesifikasi : '-' }}</td>
                        <td>{{ $trx->jumlah }}</td>
                        <td>{{ $trx->tanggal }}</td>
                        <td>{{ $trx->keterangan }}</td>
                        <td><form action="{{ route('transaksi-aset.destroy', $trx->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus transaksi ini?')">Hapus</button>
                        </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">Belum ada transaksi masuk.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
