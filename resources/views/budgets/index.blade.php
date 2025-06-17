
@extends('layouts.app')
@section('title', 'Daftar Anggaran')
@section('content')
<div class="container">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Daftar Anggaran</h5>
            <a href="{{ route('budgets.create') }}" class="btn btn-primary">Input Anggaran Baru</a>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Kategori</th>
                            <th>Nominal</th>
                            <th>Persentase dari Gaji</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($budgets as $budget)
                        <tr>
                            <td>{{ ucfirst(str_replace('_', ' ', $budget->category)) }}</td>
                            <td>Rp {{ number_format($budget->amount, 0, ',', '.') }}</td>
                            <td>
                                @if($latestSalary)
                                    {{ number_format(($budget->amount / $latestSalary->amount) * 100, 1) }}%
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted">Belum ada data anggaran.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection