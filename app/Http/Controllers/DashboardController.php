<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Salary;
use App\Models\Saving;
use App\Models\Budget;
use App\Models\Transaction;

class DashboardController extends Controller
{
    public function index()
{
    $user = Auth::user();

    // Get user-specific data
    $salary = Salary::where('user_id', $user->id)->latest()->first();
    $saving = Saving::where('user_id', $user->id)->sum('amount');
    $budgets = Budget::where('user_id', $user->id)->get();
    $transactions = Transaction::where('user_id', $user->id)
        ->with('category')
        ->latest('transaction_date')
        ->get();

    // Chart data
    $chartData = [
        'labels' => $budgets->pluck('category')->map(function($cat) {
            return ucfirst(str_replace('_', ' ', $cat));
        }),
        'datasets' => [[
            'label' => 'Anggaran',
            'data' => $budgets->pluck('amount'),
            'backgroundColor' => ['#0d6efd', '#198754', '#ffc107'],
        ]]
    ];

    // Yearly savings calculation
    $cadangan = $salary ? $salary->amount * 12 : 0;

    return view('dashboard', compact(
        'salary', 
        'saving', 
        'budgets', 
        'chartData', 
        'cadangan',
        'transactions'
    ));
}
}