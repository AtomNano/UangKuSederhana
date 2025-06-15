<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TransactionController extends Controller
{
    /**
     * Create a new controller instance.
    
    /**
     * Display a listing of transactions.
     */
    
    public function index()
    {
        try {
            $user = Auth::user();
            $transactions = $user->transactions()
                ->with('category')
                ->latest('transaction_date')
                ->get();
            
            $categories = Category::orderBy('name')->get();

            $totalIncome = $transactions->where('category.type', 'pemasukan')->sum('amount');
            $totalExpense = $transactions->where('category.type', 'pengeluaran')->sum('amount');
            $totalBalance = $totalIncome - $totalExpense;

            return view('transactions.index', compact(
                'transactions',
                'categories',
                'totalBalance',
                'totalIncome',
                'totalExpense'
            ));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memuat data.');
        }
    }

    /**
     * Store a newly created transaction.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'amount' => 'required|numeric|min:0',
                'category_id' => 'required|exists:categories,id',
                'description' => 'required|string|max:255',
                'transaction_date' => 'required|date',
            ]);

            $validated['user_id'] = Auth::id();
            Transaction::create($validated);

            return redirect()
                ->route('transactions.index')
                ->with('success', 'Transaksi berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal menambahkan transaksi.');
        }
    }

    /**
     * Update the specified transaction.
     */
    public function update(Request $request, Transaction $transaction)
    {
        try {
            if ($transaction->user_id !== Auth::id()) {
                abort(403, 'TINDAKAN TIDAK DIIZINKAN');
            }

            $validated = $request->validate([
                'amount' => 'required|numeric|min:0',
                'category_id' => 'required|exists:categories,id',
                'description' => 'required|string|max:255',
                'transaction_date' => 'required|date',
            ]);

            $transaction->update($validated);

            return redirect()
                ->route('transactions.index')
                ->with('success', 'Transaksi berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui transaksi.');
        }
    }

    /**
     * Remove the specified transaction.
     */
    public function destroy(Transaction $transaction)
    {
        try {
            if ($transaction->user_id !== Auth::id()) {
                abort(403, 'TINDAKAN TIDAK DIIZINKAN');
            }

            $transaction->delete();

            return redirect()
                ->route('transactions.index')
                ->with('success', 'Transaksi berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Gagal menghapus transaksi.');
        }
    }
}