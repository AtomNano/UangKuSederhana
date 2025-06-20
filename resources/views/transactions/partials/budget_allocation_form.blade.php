
<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center bg-white py-3">
        <h5 class="mb-0">Distribusi Anggaran</h5>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#budgetModal">
            + Tambah Distribusi
        </button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Kategori</th>
                        <th>Jumlah</th>
                        <th>Persentase</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $totalBudget = $budgets->sum('amount');
                    @endphp
                    @forelse($budgetCategories as $category)
                        @php
                            $amount = $budgets->get($category, collect())->sum('amount');
                            $percentage = $totalBudget > 0 ? ($amount / $totalBudget) * 100 : 0;
                        @endphp
                        <tr>
                            <td>{{ $category }}</td>
                            <td>Rp {{ number_format($amount, 0, ',', '.') }}</td>
                            <td>{{ number_format($percentage, 1) }}%</td>
                            <td>
                                @if($percentage >= 100)
                                    <span class="badge bg-danger">Melebihi Target</span>
                                @elseif($percentage >= 80)
                                    <span class="badge bg-warning">Mendekati Limit</span>
                                @else
                                    <span class="badge bg-success">Normal</span>
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-sm btn-info" onclick="editBudget('{{ $category }}', {{ $amount }})">
                                    Edit
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">Belum ada distribusi anggaran</td>
                        </tr>
                    @endforelse
                </tbody>
                <tfoot class="table-light">
                    <tr class="fw-bold">
                        <td>Total</td>
                        <td>Rp {{ number_format($totalBudget, 0, ',', '.') }}</td>
                        <td>100%</td>
                        <td colspan="2"></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<!-- Modal Distribusi Anggaran -->
<div class="modal fade" id="budgetModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="budgetModalLabel">Tambah Distribusi Anggaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('transactions.store') }}" method="POST">
                @csrf
                <input type="hidden" name="is_budget" value="1">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="budget_category" class="form-label">Kategori Anggaran</label>
                        <select class="form-select" id="budget_category" name="category_id" required>
                            <option value="">Pilih Kategori...</option>
                            @foreach($categories->where('type', 'pengeluaran') as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="budget_amount" class="form-label">Jumlah (Rp)</label>
                        <input type="number" class="form-control" id="budget_amount" name="amount" min="0" required>
                    </div>
                    <div class="mb-3">
                        <label for="budget_description" class="form-label">Keterangan</label>
                        <input type="text" class="form-control" id="budget_description" name="description" required>
                    </div>
                    <input type="hidden" name="transaction_date" value="{{ date('Y-m-d') }}">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
