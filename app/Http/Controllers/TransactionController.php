<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Category;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        // Ambil semua transaksi, diurutkan dari yang terbaru
        $transactions = Transaction::with('category')->latest()->get();
        // Ambil semua kategori untuk form
        $categories = Category::orderBy('name')->get();

        // Hitung total pemasukan
        $totalIncome = $transactions->where('category.type', 'pemasukan')->sum('amount');
        // Hitung total pengeluaran
        $totalExpense = $transactions->where('category.type', 'pengeluaran')->sum('amount');
        // Hitung saldo total
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
        $request->validate([
            'amount' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string|max:255',
            'transaction_date' => 'required|date',
        ]);

        Transaction::create($request->all());

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil ditambahkan!');
    }

    public function update(Request $request, Transaction $transaction)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string|max:255',
            'transaction_date' => 'required|date',
        ]);

        $transaction->update($request->all());

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil diperbarui!');
    }

    public function destroy(Transaction $transaction)
    {
        $transaction->delete();
        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil dihapus!');
    }
}