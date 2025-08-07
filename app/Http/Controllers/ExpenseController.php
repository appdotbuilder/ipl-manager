<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreExpenseRequest;
use App\Models\ActivityLog;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ExpenseController extends Controller
{
    /**
     * Display a listing of expenses.
     */
    public function index(Request $request)
    {
        $query = Expense::query();

        // Filter by search term
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('description', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Filter by date range
        if ($request->filled('start_date')) {
            $query->where('expense_date', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->where('expense_date', '<=', $request->end_date);
        }

        $expenses = $query->latest('expense_date')->paginate(20)->withQueryString();

        // Get unique categories for filter
        $categories = Expense::distinct()->pluck('category')->filter()->sort()->values();

        return Inertia::render('expenses/index', [
            'expenses' => $expenses,
            'filters' => $request->only(['search', 'category', 'start_date', 'end_date']),
            'categories' => $categories,
        ]);
    }

    /**
     * Show the form for creating a new expense.
     */
    public function create()
    {
        $categories = Expense::distinct()->pluck('category')->filter()->sort()->values();
        
        return Inertia::render('expenses/create', [
            'categories' => $categories,
        ]);
    }

    /**
     * Store a newly created expense.
     */
    public function store(StoreExpenseRequest $request)
    {
        $expense = Expense::create($request->validated());

        // Log the activity
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'created',
            'entity_type' => 'Expense',
            'entity_id' => $expense->id,
            'new_values' => $expense->toArray(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        return redirect()->route('expenses.index')
            ->with('success', 'Data pengeluaran berhasil ditambahkan.');
    }

    /**
     * Display the specified expense.
     */
    public function show(Expense $expense)
    {
        return Inertia::render('expenses/show', [
            'expense' => $expense,
        ]);
    }

    /**
     * Show the form for editing the specified expense.
     */
    public function edit(Expense $expense)
    {
        $categories = Expense::distinct()->pluck('category')->filter()->sort()->values();
        
        return Inertia::render('expenses/edit', [
            'expense' => $expense,
            'categories' => $categories,
        ]);
    }

    /**
     * Update the specified expense.
     */
    public function update(StoreExpenseRequest $request, Expense $expense)
    {
        $oldValues = $expense->toArray();
        $expense->update($request->validated());

        // Log the activity
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'updated',
            'entity_type' => 'Expense',
            'entity_id' => $expense->id,
            'old_values' => $oldValues,
            'new_values' => $expense->toArray(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        return redirect()->route('expenses.show', $expense)
            ->with('success', 'Data pengeluaran berhasil diperbarui.');
    }

    /**
     * Remove the specified expense.
     */
    public function destroy(Expense $expense)
    {
        $oldValues = $expense->toArray();
        $expense->delete();

        // Log the activity
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'deleted',
            'entity_type' => 'Expense',
            'entity_id' => $expense->id,
            'old_values' => $oldValues,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        return redirect()->route('expenses.index')
            ->with('success', 'Data pengeluaran berhasil dihapus.');
    }
}