@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
<div class="container">
    <h3 class="mb-4">Dashboard Keuangan</h3>
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card text-bg-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Gaji Bulanan Terakhir</h5>
                    <p class="card-text fs-4">Rp {{ $salary ? number_format($salary->amount,0,',','.') : '0' }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-bg-success mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Tabungan (10%)</h5>
                    <p class="card-text fs-4">Rp {{ number_format($saving,0,',','.') }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-bg-warning mb-3">
                <div class="card-body">
                    <h5 class="card-title">Cadangan 1 Tahun</h5>
                    <p class="card-text fs-4">Rp {{ number_format($cadangan,0,',','.') }}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="card mb-4">
        <div class="card-header">Distribusi Anggaran</div>
        <div class="card-body">
            <canvas id="budgetChart"></canvas>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('budgetChart').getContext('2d');
const chartData = @json($chartData);
new Chart(ctx, {
    type: 'pie',
    data: {
        labels: chartData.labels,
        datasets: chartData.datasets
    }
});
</script>
@endsection