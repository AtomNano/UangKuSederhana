<?php


namespace App\Http\Controllers;

use App\Models\Budget;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BudgetController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'amount' => 'required|numeric|min:0',
            'period' => 'required|date_format:Y-m'
        ]);

        $validated['user_id'] = Auth::id();

        Budget::create($validated);

        return redirect()->back()->with('success', 'Distribusi anggaran berhasil ditambahkan');
    }

    public function update(Request $request, Budget $budget)
    {
        if ($budget->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'amount' => 'required|numeric|min:0',
            'period' => 'required|date_format:Y-m'
        ]);

        $budget->update($validated);

        return redirect()->back()->with('success', 'Distribusi anggaran berhasil diperbarui');
    }

    public function destroy(Budget $budget)
    {
        if ($budget->user_id !== Auth::id()) {
            abort(403);
        }

        $budget->delete();

        return redirect()->back()->with('success', 'Distribusi anggaran berhasil dihapus');
    }
}