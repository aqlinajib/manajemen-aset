@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Transaksi Barang Masuk/Keluar</h2>
    <form action="{{ route('transaksi-aset.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Pilih Aset</label>
            <select name="aset_id" class="form-control" required>
                <option value="">-- Pilih Aset --</option>
                @foreach($asets as $aset)
                    <option value="{{ $aset->id }}">
                        {{ $aset->kategori }} | {{ $aset->merk }} | {{ $aset->spesifikasi }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label>Jumlah</label>
            <input type="number" name="jumlah" class="form-control" min="1" required>
        </div>
        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control" required>
                <option value="">-- Pilih Status --</option>
                <option value="Masuk">Masuk</option>
                <option value="Keluar">Keluar</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Tanggal</label>
            <input type="date" name="tanggal" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Pilih Progress</label>
            <select name="progress" class="form-control" required>
                <option value="">-- Pilih Aset --</option>
                <option value="done">Done</option>
                <option value="on progress">On Progress</option>
                <option value="canceled">Canceled</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Keterangan (Opsional)</label>
            <textarea name="keterangan" class="form-control"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Simpan Transaksi</button>
    </form>
</div>
@endsection
