
<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Distribusi Anggaran</h5>
        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#budgetModal">
            <i class="bi bi-plus-circle me-1"></i> Tambah
        </button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Kategori</th>
                        <th>Alokasi</th>
                        <th>Terpakai</th>
                        <th>Sisa</th>
                        <th>Progress</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
    @foreach($budgets as $categoryName => $budgetGroup)
        @php
            $firstBudget = $budgetGroup->first();
            $totalAmount = $budgetGroup->sum('amount');
            $used = $budgetGroup->sum('used'); // Pastikan ada kolom 'used' di tabel budgets, jika tidak, sesuaikan
            $percentage = $totalAmount > 0 ? ($used / $totalAmount) * 100 : 0;
        @endphp
        <tr>
            <td>{{ $firstBudget->category->name ?? $categoryName }}</td>
            <td>Rp {{ number_format($totalAmount, 0, ',', '.') }}</td>
            <td>Rp {{ number_format($used, 0, ',', '.') }}</td>
            <td>Rp {{ number_format($totalAmount - $used, 0, ',', '.') }}</td>
            <td>
                <div class="progress">
                    <div class="progress-bar {{ $percentage > 90 ? 'bg-danger' : ($percentage > 70 ? 'bg-warning' : 'bg-success') }}"
                        role="progressbar"
                        style="width: {{ $percentage }}%">
                        {{ number_format($percentage, 0) }}%
                    </div>
                </div>
            </td>
            <td>
                <button class="btn btn-sm btn-info" onclick="editBudget({{ $firstBudget->id }})">
                    <i class="bi bi-pencil"></i>
                </button>
            </td>
        </tr>
    @endforeach
    @if($budgets->isEmpty())
        <tr>
            <td colspan="6" class="text-center text-muted">
                Belum ada distribusi anggaran yang ditambahkan
            </td>
        </tr>
    @endif
</tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Distribusi Anggaran -->
<div class="modal fade" id="budgetModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('budgets.store') }}" method="POST" id="budgetForm">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Distribusi Anggaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Kategori</label>
                        <select class="form-select" name="category_id" required>
                            <option value="">Pilih Kategori...</option>
                            @foreach($budgetCategories as $category)
    <li>
        {{ $category->name }}: Rp {{ number_format($budgets->get($category->name, collect())->sum('amount'),0,',','.') }}
    </li>
@endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jumlah Alokasi</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" class="form-control" name="amount" required min="0">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Periode</label>
                        <input type="month" class="form-control" name="period" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>