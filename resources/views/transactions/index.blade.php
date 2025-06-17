@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')

{{-- Menampilkan notifikasi error --}}

{{-- Menampilkan notifikasi sukses --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

{{-- Menampilkan error validasi --}}
@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
         <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif


<!-- Kartu Ringkasan -->
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


<!-- Breakdown Pengeluaran -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">Breakdown Pengeluaran</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    @php
                        $expenseCategories = $categories->where('type', 'pengeluaran');
                        $colors = ['primary', 'success', 'warning', 'info', 'danger', 'secondary'];
                    @endphp
                    
                    @foreach($expenseCategories as $index => $category)
                        @php
                            $categoryTotal = $transactions
                                ->where('category_id', $category->id)
                                ->sum('amount');
                            $percentage = $totalExpense > 0 
                                ? ($categoryTotal / $totalExpense) * 100 
                                : 0;
                            $color = $colors[$index % count($colors)];
                        @endphp
                        
                        <div class="col-md-6 col-lg-4 mb-3">
                            <div class="card border-{{ $color }}">
                                <div class="card-body">
                                    <h6 class="card-title d-flex justify-content-between">
                                        <span>{{ $category->name }}</span>
                                        <span class="badge bg-{{ $color }}">
                                            {{ number_format($percentage, 1) }}%
                                        </span>
                                    </h6>
                                    <p class="card-text fw-bold mb-0">
                                        Rp {{ number_format($categoryTotal, 0, ',', '.') }}
                                    </p>
                                    <div class="progress mt-2" style="height: 5px;">
                                        <div class="progress-bar bg-{{ $color }}" 
                                             role="progressbar" 
                                             style="width: {{ $percentage }}%">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tabel Transaksi -->
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center bg-white py-3">
        <h5 class="mb-0">Daftar Transaksi</h5>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
            + Tambah Transaksi
        </button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Tanggal</th>
                        <th>Deskripsi</th>
                        <th>Kategori</th>
                        <th class="text-end">Jumlah</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($transactions as $transaction)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($transaction->transaction_date)->format('d M Y') }}</td>
                        <td>{{ $transaction->description }}</td>
                        <td>
                            <span class="badge {{ $transaction->category->type == 'pemasukan' ? 'bg-success-subtle text-success-emphasis' : 'bg-danger-subtle text-danger-emphasis' }}">
                                {{ $transaction->category->name }}
                            </span>
                        </td>
                        <td class="text-end fw-bold {{ $transaction->category->type == 'pemasukan' ? 'text-success' : 'text-danger' }}">
                            {{ $transaction->category->type == 'pemasukan' ? '+' : '-' }} Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                        </td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-warning edit-btn" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#editModal"
                                    data-id="{{ $transaction->id }}"
                                    data-amount="{{ $transaction->amount }}"
                                    data-category_id="{{ $transaction->category_id }}"
                                    data-description="{{ $transaction->description }}"
                                    data-transaction_date="{{ $transaction->transaction_date }}">
                                Edit
                            </button>
                            <form action="{{ route('transactions.destroy', $transaction->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus transaksi ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">Belum ada transaksi.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah Transaksi -->
<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="createModalLabel">Tambah Transaksi Baru</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('transactions.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="transaction_date" class="form-label">Tanggal</label>
                        <input type="date" class="form-control" id="transaction_date" name="transaction_date" value="{{ date('Y-m-d') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="category_id" class="form-label">Kategori</label>
                        <select class="form-select" id="category_id" name="category_id" required>
                            <option value="">Pilih Kategori</option>
                            <optgroup label="Pemasukan">
                                @foreach($categories->where('type', 'pemasukan') as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </optgroup>
                            <optgroup label="Pengeluaran">
                                @foreach($categories->where('type', 'pengeluaran') as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </optgroup>
                        </select>
                    </div>
                     <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi</label>
                        <input type="text" class="form-control" id="description" name="description" required>
                    </div>
                    <div class="mb-3">
                        <label for="amount" class="form-label">Jumlah (Rp)</label>
                        <input type="number" class="form-control" id="amount" name="amount" min="0" required>
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

<!-- Modal Edit Transaksi -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editModalLabel">Edit Transaksi</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                     <div class="mb-3">
                        <label for="edit_transaction_date" class="form-label">Tanggal</label>
                        <input type="date" class="form-control" id="edit_transaction_date" name="transaction_date" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_category_id" class="form-label">Kategori</label>
                        <select class="form-select" id="edit_category_id" name="category_id" required>
                            <option value="">Pilih Kategori</option>
                            <optgroup label="Pemasukan">
                                @foreach($categories->where('type', 'pemasukan') as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </optgroup>
                            <optgroup label="Pengeluaran">
                                @foreach($categories->where('type', 'pengeluaran') as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </optgroup>
                        </select>
                    </div>
                     <div class="mb-3">
                        <label for="edit_description" class="form-label">Deskripsi</label>
                        <input type="text" class="form-control" id="edit_description" name="description" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_amount" class="form-label">Jumlah (Rp)</label>
                        <input type="number" class="form-control" id="edit_amount" name="amount" min="0" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Edit Modal Handler
    const editModal = document.getElementById('editModal');
    if (editModal) {
        editModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            if (!button) return;

            // Get data attributes
            const id = button.getAttribute('data-id');
            const amount = button.getAttribute('data-amount');
            const categoryId = button.getAttribute('data-category_id');
            const description = button.getAttribute('data-description');
            const transactionDate = button.getAttribute('data-transaction_date');
            
            // Update form
            const form = document.getElementById('editForm');
            if (form) {
                form.action = `/transactions/${id}`;
                
                // Add hidden input for edit form identification
                let hiddenInput = form.querySelector('input[name="is_edit_form"]');
                if (!hiddenInput) {
                    hiddenInput = document.createElement('input');
                    hiddenInput.type = 'hidden';
                    hiddenInput.name = 'is_edit_form';
                    hiddenInput.value = '1';
                    form.appendChild(hiddenInput);
                }

                // Update form fields
                form.querySelector('#edit_amount').value = amount;
                form.querySelector('#edit_category_id').value = categoryId;
                form.querySelector('#edit_description').value = description;
                form.querySelector('#edit_transaction_date').value = transactionDate;
            }
        });
    }

    // Validation Error Handler
    @if ($errors->any())
        try {
            const modalId = '{{ old("is_edit_form") ? "editModal" : "createModal" }}';
            const modal = new bootstrap.Modal(document.getElementById(modalId));
            modal.show();
        } catch (e) {
            console.error('Error showing modal:', e);
        }
    @endif

    // Delete Confirmation
    const deleteButtons = document.querySelectorAll('.delete-btn');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            if (!confirm('Apakah Anda yakin ingin menghapus transaksi ini?')) {
                e.preventDefault();
            }
        });
    });
});
</script>
@endpush