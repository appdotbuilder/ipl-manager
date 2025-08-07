<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\IplPayment;
use App\Models\Resident;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DataSyncController extends Controller
{
    /**
     * Display the data sync dashboard.
     */
    public function index()
    {
        // Get data statistics
        $stats = [
            'total_residents' => Resident::count(),
            'total_ipl_payments' => IplPayment::count(),
            'paid_payments' => IplPayment::paid()->count(),
            'unpaid_payments' => IplPayment::unpaid()->count(),
        ];

        // Get recent sync activities
        $recentSyncActivities = ActivityLog::where('entity_type', 'DataSync')
            ->with('user')
            ->latest()
            ->take(10)
            ->get();

        return Inertia::render('data-sync/index', [
            'stats' => $stats,
            'recent_sync_activities' => $recentSyncActivities,
        ]);
    }

    /**
     * Show the form for creating a new import.
     */
    public function create()
    {
        return Inertia::render('data-sync/import');
    }

    /**
     * Store a newly created import.
     */
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,xlsx,xls|max:5120', // 5MB max
        ]);

        try {
            // This is a placeholder for actual Google Sheets integration
            // In a real implementation, you would use libraries like:
            // - Laravel Excel for file processing
            // - Google Sheets API for direct integration
            
            // Log the import activity
            ActivityLog::create([
                'user_id' => Auth::id(),
                'action' => 'import_data',
                'entity_type' => 'DataSync',
                'new_values' => [
                    'filename' => $request->file('file')->getClientOriginalName(),
                    'size' => $request->file('file')->getSize(),
                ],
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);

            return redirect()->route('data-sync.index')
                ->with('success', 'Data berhasil diimpor. (Fitur ini akan diimplementasi dengan Google Sheets API)');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['import' => 'Gagal mengimpor data: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified data sync.
     */
    public function show(Request $request)
    {
        try {
            // This is a placeholder for actual Google Sheets integration
            // In a real implementation, you would:
            // 1. Connect to Google Sheets API
            // 2. Create a new spreadsheet
            // 3. Export all IPL payment data
            // 4. Return the spreadsheet URL

            $timestamp = now()->format('Y-m-d_H-i-s');
            $filename = "IPL_Backup_{$timestamp}";

            // Log the export activity
            ActivityLog::create([
                'user_id' => Auth::id(),
                'action' => 'export_data',
                'entity_type' => 'DataSync',
                'new_values' => [
                    'filename' => $filename,
                    'total_records' => IplPayment::count(),
                    'export_timestamp' => $timestamp,
                ],
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);

            return redirect()->back()
                ->with('success', "Data berhasil diekspor ke Google Sheets: {$filename} (Fitur ini akan diimplementasi dengan Google Sheets API)");

        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['export' => 'Gagal mengekspor data: ' . $e->getMessage()]);
        }
    }

    /**
     * Update the specified data sync.
     */
    public function update(Request $request)
    {
        $request->validate([
            'sheet_url' => 'required|url',
        ]);

        try {
            // This is a placeholder for actual Google Sheets integration
            // In a real implementation, you would:
            // 1. Parse the Google Sheets URL
            // 2. Connect to the specific sheet
            // 3. Update the data with latest records
            
            // Log the update activity
            ActivityLog::create([
                'user_id' => Auth::id(),
                'action' => 'update_sheet',
                'entity_type' => 'DataSync',
                'new_values' => [
                    'sheet_url' => $request->sheet_url,
                    'total_records' => IplPayment::count(),
                    'update_timestamp' => now()->format('Y-m-d H:i:s'),
                ],
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);

            return redirect()->back()
                ->with('success', 'Google Sheets berhasil diperbarui dengan data terbaru. (Fitur ini akan diimplementasi dengan Google Sheets API)');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['update' => 'Gagal memperbarui Google Sheets: ' . $e->getMessage()]);
        }
    }
}