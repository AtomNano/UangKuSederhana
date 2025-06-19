@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
    {{-- 1. Menampilkan Notifikasi --}}
    @include('transactions.partials.notifications')

    {{-- 2. Kartu Ringkasan --}}
    @include('transactions.partials.summary_cards', [
        'totalBalance' => $totalBalance,
        'totalIncome' => $totalIncome,
        'totalExpense' => $totalExpense
    ])

    {{-- 3. Breakdown Pengeluaran --}}
    @include('transactions.partials.expense_breakdown', [
        'totalExpense' => $totalExpense
    ])

    {{-- 4. Tabel Transaksi --}}
    @include('transactions.partials.transactions_table', ['transactions' => $transactions])

    {{-- 5. Modal Tambah & Edit --}}
    @include('transactions.partials.create_modal', ['categories' => $categories])
    @include('transactions.partials.edit_modal', ['categories' => $categories])
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Handler untuk menampilkan data pada Edit Modal
    const editModal = document.getElementById('editModal');
    if (editModal) {
        editModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            if (!button) return;

            // Ambil data dari atribut data-* pada tombol edit
            const id = button.getAttribute('data-id');
            const amount = button.getAttribute('data-amount');
            const categoryId = button.getAttribute('data-category_id');
            const description = button.getAttribute('data-description');
            const transactionDate = button.getAttribute('data-transaction_date');

            // Update form di dalam modal
            const form = document.getElementById('editForm');
            if (form) {
                // Set action form sesuai dengan ID transaksi
                form.action = `/transactions/${id}`;
                
                // Isi field-field form dengan data yang didapat
                form.querySelector('#edit_amount').value = amount;
                form.querySelector('#edit_category_id').value = categoryId;
                form.querySelector('#edit_description').value = description;
                form.querySelector('#edit_transaction_date').value = transactionDate;
            }
        });
    }

    // Handler untuk menampilkan kembali modal jika ada error validasi dari server
    @if ($errors->any())
        try {
            // Cek apakah error berasal dari form edit atau create
            const modalId = '{{ session()->get('form_type') === 'edit' ? "editModal" : "createModal" }}';
            const modalToShow = new bootstrap.Modal(document.getElementById(modalId));
            modalToShow.show();
        } catch (e) {
            console.error('Error showing validation modal:', e);
        }
    @endif
});

// Anda sudah memiliki konfirmasi `onsubmit` di form, jadi event listener tambahan tidak diperlukan.
// Jika ingin memisahkan, pastikan hanya ada satu metode konfirmasi yang digunakan.
</script>
@endpush