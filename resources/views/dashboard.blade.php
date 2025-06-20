@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
<div class="container">
    <div class="row mb-4">
        <!-- Saldo & Tabungan -->
        <div class="col-md-3">
            <div class="card text-bg-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Saldo</h5>
                    <p class="card-text fs-4">Rp {{ number_format($balance,0,',','.') }}</p>
                    <small>Saldo Setelah Tabungan: Rp {{ number_format($availableBalance,0,',','.') }}</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-bg-success mb-3">
                <div class="card-body">
                    <h5 class="card-title">Tabungan (10%)</h5>
                    <p class="card-text fs-4">Rp {{ number_format($saving,0,',','.') }}</p>
                    <small>Dari Gaji: Rp {{ number_format($latestSalary->amount ?? 0,0,',','.') }}</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-bg-warning mb-3">
                <div class="card-body">
                    <h5 class="card-title">Target 1 Tahun</h5>
                    <p class="card-text fs-4">Rp {{ number_format($cadangan,0,',','.') }}</p>
                    <small>Cadangan dari Gaji x 12</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-bg-info mb-3">
                <div class="card-body">
                    <h5 class="card-title">Input Anggaran</h5>
                    <a href="{{ route('transactions.index') }}?type=pengeluaran" class="btn btn-light btn-sm w-100">
                        Tambah Anggaran Baru
                    </a>
                </div>
            </div>
        </div>
    </div>

     @include('transactions.partials.budget_distribution')

    <div class="row">
        <!-- Grafik Anggaran -->
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">Distribusi Anggaran</div>
                <div class="card-body">
                    <canvas id="budgetChart" style="max-width: 300px; max-height: 300px;"></canvas>
                </div>
            </div>
        </div>
        
        <!-- Rincian Anggaran -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Rincian Anggaran</div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                    @foreach($budgetCategories as $category)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ $category->name }}
                            <span class="badge bg-primary rounded-pill">
                                Rp {{ number_format($budgets->get($category->name, collect())->sum('amount'),0,',','.') }}
                            </span>
                        </li>
                    @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('budgetChart');
    const chartConfig = @json($chartConfig);
    
    new Chart(ctx, {
        type: 'pie',
        data: chartConfig,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
    window.editBudget = function(category, amount) {
        const modal = new bootstrap.Modal(document.getElementById('budgetModal'));
        document.getElementById('budgetModalLabel').textContent = 'Edit Distribusi Anggaran';
        document.getElementById('budget_category').value = category;
        document.getElementById('budget_amount').value = amount;
        modal.show();
    }
});


</script>
@endpush
@endsection