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
                    
                    @forelse($expenseCategories as $index => $category)
                        @php
                            $categoryTotal = $transactions->where('category_id', $category->id)->sum('amount');
                            $percentage = $totalExpense > 0 ? ($categoryTotal / $totalExpense) * 100 : 0;
                            $color = $colors[$index % count($colors)];
                        @endphp
                        
                        <div class="col-md-6 col-lg-4 mb-3">
                            <div class="card border-{{ $color }}">
                                <div class="card-body">
                                    <h6 class="card-title d-flex justify-content-between">
                                        <span>{{ $category->name }}</span>
                                        <span class="badge bg-{{ $color }}">{{ number_format($percentage, 1) }}%</span>
                                    </h6>
                                    <p class="card-text fw-bold mb-0">
                                        Rp {{ number_format($categoryTotal, 0, ',', '.') }}
                                    </p>
                                    <div class="progress mt-2" style="height: 5px;">
                                        <div class="progress-bar bg-{{ $color }}" role="progressbar" style="width: {{ $percentage }}%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <p class="text-muted text-center">Belum ada kategori pengeluaran.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>