<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index()
    {
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
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string|max:255',
            'transaction_date' => 'required|date',
        ]);

        $validated['user_id'] = Auth::id();
        Transaction::create($validated);

        return redirect()->route('transactions.index')
            ->with('success', 'Transaksi berhasil ditambahkan!');
    }

    public function update(Request $request, Transaction $transaction)
    {
        if ($transaction->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'amount' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string|max:255',
            'transaction_date' => 'required|date',
        ]);

        $transaction->update($validated);

        return redirect()->route('transactions.index')
            ->with('success', 'Transaksi berhasil diperbarui!');
    }

    public function destroy(Transaction $transaction)
    {
        if ($transaction->user_id !== Auth::id()) {
            abort(403);
        }

        $transaction->delete();

        return redirect()->route('transactions.index')
            ->with('success', 'Transaksi berhasil dihapus!');
    }
}