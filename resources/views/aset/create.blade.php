@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Input Data Aset</h2>
    <form action="{{ route('aset.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Kategori</label>
            <select name="kategori" class="form-control" required>
                <option value="">-- Pilih Kategori --</option>
                <option value="jok mobil">Jok Mobil</option>
                <option value="jok motor">Jok Motor</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Merk</label>
            <input type="text" name="merk" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Spesifikasi</label>
            <textarea name="spesifikasi" class="form-control" required></textarea>
        </div>
        <div class="mb-3">
            <label>Jumlah</label>
            <input type="number" name="jumlah" class="form-control" required min="1">
        </div>
        <div class="mb-3">
            <label>Tanggal</label>
            <input type="date" name="tanggal" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control" required>
                <option value="">-- Pilih Status --</option>
                <option value="masuk">Masuk</option>
                <option value="keluar">Keluar</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Progress</label>
            <select name="progress" class="form-control" required>
                <option value="">-- Pilih Progress --</option>
                <option value="done">Done</option>
                <option value="on progress">On Progress</option>
                <option value="canceled">Canceled</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection
