<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editModalLabel">Edit Transaksi</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editForm" method="POST"> {{-- Action-nya di-set via JS --}}
                @csrf
                @method('PUT')
                <div class="modal-body">
                     <div class="mb-3">
                        <label for="edit_transaction_date" class="form-label">Tanggal</label>
                        <input type="date" class="form-control" id="edit_transaction_date" name="transaction_date" value="{{ old('transaction_date') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_category_id" class="form-label">Kategori</label>
                        <select class="form-select" id="edit_category_id" name="category_id" required>
                            <option value="">Pilih Kategori</option>
                            <optgroup label="Pemasukan">
                                @foreach($categories->where('type', 'pemasukan') as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                @endforeach
                            </optgroup>
                            <optgroup label="Pengeluaran">
                                @foreach($categories->where('type', 'pengeluaran') as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                @endforeach
                            </optgroup>
                        </select>
                    </div>
                     <div class="mb-3">
                        <label for="edit_description" class="form-label">Deskripsi</label>
                        <input type="text" class="form-control" id="edit_description" name="description" value="{{ old('description') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_amount" class="form-label">Jumlah (Rp)</label>
                        <input type="number" class="form-control" id="edit_amount" name="amount" min="0" value="{{ old('amount') }}" required>
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