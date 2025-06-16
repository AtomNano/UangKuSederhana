<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Salary;
use App\Models\Saving;
use App\Models\Budget;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $salary = Salary::where('user_id', $user->id)->latest()->first();
        $saving = Saving::where('user_id', $user->id)->sum('amount');
        $budgets = Budget::where('user_id', $user->id)->get();

        // Data untuk chart
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

        // Perhitungan uang cadangan 1 tahun
        $cadangan = $salary ? $salary->amount * 12 : 0;

        return view('dashboard', compact('salary', 'saving', 'budgets', 'chartData', 'cadangan'));
    }
}