<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Budget;
use App\Models\Salary;
use Illuminate\Support\Facades\Auth;

class BudgetController extends Controller
{
    public function index()
    {
        $budgets = Budget::where('user_id', Auth::id())->get();
        $latestSalary = Salary::where('user_id', Auth::id())->latest()->first();
        
        return view('budgets.index', compact('budgets', 'latestSalary'));
    }

    public function create()
    {
        return view('budgets.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'category' => 'required|string',
            'amount' => 'required|numeric|min:0',
        ]);

        Budget::create([
            'user_id' => Auth::id(),
            'category' => $request->category,
            'amount' => $request->amount,
        ]);

        return redirect()->route('budgets.index')->with('success', 'Anggaran berhasil disimpan!');
    }
}