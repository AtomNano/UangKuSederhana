@extends('layouts.app')
@section('title', 'Daftar Anggaran')
@section('content')
<div class="container">
    <h3 class="mb-3">Daftar Anggaran</h3>
    <a href="{{ route('budgets.create') }}" class="btn btn-primary mb-3">Input Anggaran Baru</a>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Kategori</th>
                <th>Nominal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($budgets as $budget)
            <tr>
                <td>{{ ucfirst($budget->category) }}</td>
                <td>Rp {{ number_format($budget->amount,0,',','.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection