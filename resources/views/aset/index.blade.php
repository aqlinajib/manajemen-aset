@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Daftar Aset</h2>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <a href="{{ route('aset.create') }}" class="btn btn-primary mb-3">+ Tambah Aset</a>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kategori</th>
                    <th>Merk</th>
                    <th>Spesifikasi</th>
                    <th>Jumlah</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th>Progress</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($asets as $aset)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $aset->kategori }}</td>
                        <td>{{ $aset->merk }}</td>
                        <td>{{ $aset->spesifikasi }}</td>
                        <td>{{ $aset->jumlah }}</td>
                        <td>{{ $aset->tanggal }}</td>
                        <td>{{ $aset->status }}</td>
                        <td>{{ $aset->progress }}</td>
                        <td>
                            <a href="{{ route('aset.edit', $aset->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('aset.destroy', $aset->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Yakin hapus?')" class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center">Belum ada data aset.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
