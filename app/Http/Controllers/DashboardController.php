<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Transaction;
use App\Models\Category;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Get latest salary and calculate savings
        $latestSalary = Transaction::where('user_id', $user->id)
            ->whereHas('category', function($q) {
                $q->where('name', 'Gaji');
            })
            ->latest()
            ->first();

        $salary = $latestSalary ? $latestSalary->amount : 0;
        $saving = $salary * 0.1;
        $cadangan = $salary * 12;

        // Calculate total balance (income - expenses)
        $totalIncome = Transaction::where('user_id', $user->id)
            ->whereHas('category', function($q) {
                $q->where('type', 'pemasukan');
            })
            ->sum('amount');

        $totalExpense = Transaction::where('user_id', $user->id)
            ->whereHas('category', function($q) {
                $q->where('type', 'pengeluaran');
            })
            ->sum('amount');

        $balance = $totalIncome - $totalExpense;
        $availableBalance = $balance - $saving; // Balance after savings

        $budgetCategories = Category::whereIn('name', [
            'Biaya Sekolah', 
            'Cicilan', 
            'Sewa/KPR'
        ])->get();

        // Get transactions for these categories
        $budgets = Transaction::where('user_id', $user->id)
            ->whereHas('category', function($q) use ($budgetCategories) {
                $q->whereIn('name', ['Biaya Sekolah', 'Cicilan', 'Sewa/KPR']);
            })
            ->with('category')
            ->get()
            ->groupBy('category.name');

        // Chart configuration
        $chartLabels = $budgetCategories->pluck('name')->toArray();
        $chartData = collect($chartLabels)->map(function($categoryName) use ($budgets) {
            return $budgets->get($categoryName, collect())->sum('amount');
        });

        $chartConfig = [
            'labels' => $chartLabels,
            'datasets' => [[
                'label' => 'Anggaran',
                'data' => $chartData,
                'backgroundColor' => ['#0d6efd', '#198754', '#ffc107'],
            ]]
        ];

        return view('dashboard', compact(
            'latestSalary',
            'saving',
            'cadangan',
            'balance',
            'availableBalance',
            'budgets',
            'chartConfig',
            'budgetCategories'  // Added this line
        ));
    }
}