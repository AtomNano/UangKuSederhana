<div class="row mb-4">
    <div class="col-md-4">
        <div class="card text-white bg-primary mb-3">
            <div class="card-header">Saldo Total</div>
            <div class="card-body">
                <h4 class="card-title fw-bold">Rp {{ number_format($totalBalance, 2, ',', '.') }}</h4>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-white bg-success mb-3">
            <div class="card-header">Total Pemasukan</div>
            <div class="card-body">
                <h4 class="card-title fw-bold">Rp {{ number_format($totalIncome, 2, ',', '.') }}</h4>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-white bg-danger mb-3">
            <div class="card-header">Total Pengeluaran</div>
            <div class="card-body">
                <h4 class="card-title fw-bold">Rp {{ number_format($totalExpense, 2, ',', '.') }}</h4>
            </div>
        </div>
    </div>
</div>