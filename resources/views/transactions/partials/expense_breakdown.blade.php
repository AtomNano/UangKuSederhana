
<div class="card mb-4">
    <div class="card-header">
        <h5 class="card-title mb-0">Breakdown Pengeluaran</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <canvas id="expenseChart" style="max-width: 300px; max-height: 300px;"></canvas>
            </div>
            <div class="col-md-6">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Kategori</th>
                                <th>Jumlah</th>
                                <th>Persentase</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $totalExpense = $transactions->whereIn('category.type', ['pengeluaran'])->sum('amount');
                                $expensesByCategory = $transactions
                                    ->whereIn('category.type', ['pengeluaran'])
                                    ->groupBy('category.name')
                                    ->map(function ($group) {
                                        return $group->sum('amount');
                                    });
                            @endphp
                            
                            @foreach($expensesByCategory as $category => $amount)
                                <tr>
                                    <td>{{ $category }}</td>
                                    <td>Rp {{ number_format($amount, 0, ',', '.') }}</td>
                                    <td>{{ number_format(($amount / $totalExpense) * 100, 1) }}%</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="fw-bold">
                                <td>Total</td>
                                <td>Rp {{ number_format($totalExpense, 0, ',', '.') }}</td>
                                <td>100%</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('expenseChart').getContext('2d');
    
    const expenseData = @json($expensesByCategory);
    const categories = Object.keys(expenseData);
    const amounts = Object.values(expenseData);
    
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: categories,
            datasets: [{
                data: amounts,
                backgroundColor: [
                    '#FF6384',
                    '#36A2EB',
                    '#FFCE56',
                    '#4BC0C0',
                    '#9966FF',
                    '#FF9F40'
                ]
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                },
                title: {
                    display: true,
                    text: 'Distribusi Pengeluaran per Kategori'
                }
            }
        }
    });
});
</script>
@endpush