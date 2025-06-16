<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Salary;
use App\Models\Saving;
use Illuminate\Support\Facades\Auth;

class SalaryController extends Controller
{
    public function index()
    {
        $salaries = Salary::where('user_id', Auth::id())->get();
        return view('salaries.index', compact('salaries'));
    }

    public function create()
    {
        return view('salaries.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0',
        ]);

        $salary = Salary::create([
            'user_id' => Auth::id(),
            'amount' => $request->amount,
        ]);

        // Otomatis simpan 10% ke tabungan
        $savingAmount = $request->amount * 0.10;
        Saving::create([
            'user_id' => Auth::id(),
            'amount' => $savingAmount,
        ]);

        return redirect()->route('salaries.index')->with('success', 'Gaji dan tabungan berhasil disimpan!');
    }
}