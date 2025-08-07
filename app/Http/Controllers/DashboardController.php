<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Expense;
use App\Models\IplPayment;
use App\Models\Resident;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class DashboardController extends Controller
{
    /**
     * Display the main dashboard.
     */
    public function index()
    {
        // Get monthly income summary for the current year
        $currentYear = date('Y');
        $monthlyIncome = IplPayment::query()
            ->where('tahun_periode', $currentYear)
            ->where('status_pembayaran', 'paid')
            ->select(
                'bulan_ipl',
                DB::raw('SUM(nominal_ipl) as total_income')
            )
            ->groupBy('bulan_ipl')
            ->get()
            ->keyBy('bulan_ipl');

        // Get total residents
        $totalResidents = Resident::count();
        
        // Get overdue payments (3+ months)
        $overduePayments = IplPayment::with('resident')
            ->overdue(3)
            ->count();

        // Get total unpaid payments
        $unpaidPayments = IplPayment::unpaid()->count();

        // Get recent activity logs
        $recentActivities = ActivityLog::with('user')
            ->latest()
            ->take(10)
            ->get();

        // Calculate total monthly expenses for current year
        $monthlyExpenses = Expense::query()
            ->whereYear('expense_date', $currentYear)
            ->select(
                DB::raw('strftime("%m", expense_date) as month'),
                DB::raw('SUM(amount) as total_expense')
            )
            ->groupBy(DB::raw('strftime("%m", expense_date)'))
            ->get()
            ->keyBy('month');

        return Inertia::render('dashboard', [
            'stats' => [
                'total_residents' => $totalResidents,
                'overdue_payments' => $overduePayments,
                'unpaid_payments' => $unpaidPayments,
                'current_year' => $currentYear,
            ],
            'monthly_income' => $monthlyIncome,
            'monthly_expenses' => $monthlyExpenses,
            'recent_activities' => $recentActivities,
        ]);
    }
}