@extends('layouts.app')
@section('title', 'Input Anggaran')
@section('content')
<div class="container">
    <h3 class="mb-3">Input Anggaran</h3>
    <form action="{{ route('budgets.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="category" class="form-label">Kategori</label>
            <select name="category" class="form-select" required>
                <option value="sekolah">Biaya Sekolah Anak</option>
                <option value="cicilan">Pembayaran Cicilan Bulanan</option>
                <option value="tempat_tinggal">Biaya Tempat Tinggal (Sewa/KPR)</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="amount" class="form-label">Nominal</label>
            <input type="number" name="amount" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('budgets.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection