<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ActivityLogController extends Controller
{
    /**
     * Display a listing of activity logs.
     */
    public function index(Request $request)
    {
        $query = ActivityLog::with('user');

        // Filter by user
        if ($request->filled('user')) {
            $query->where('user_id', $request->user);
        }

        // Filter by action
        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        // Filter by entity type
        if ($request->filled('entity_type')) {
            $query->where('entity_type', $request->entity_type);
        }

        // Filter by date range
        if ($request->filled('start_date')) {
            $query->where('created_at', '>=', $request->start_date . ' 00:00:00');
        }

        if ($request->filled('end_date')) {
            $query->where('created_at', '<=', $request->end_date . ' 23:59:59');
        }

        $activityLogs = $query->latest()->paginate(50)->withQueryString();

        // Get filter options
        $users = \App\Models\User::select('id', 'name')->get();
        $actions = ActivityLog::distinct()->pluck('action')->sort()->values();
        $entityTypes = ActivityLog::distinct()->pluck('entity_type')->sort()->values();

        return Inertia::render('activity-logs/index', [
            'activity_logs' => $activityLogs,
            'filters' => $request->only(['user', 'action', 'entity_type', 'start_date', 'end_date']),
            'users' => $users,
            'actions' => $actions,
            'entity_types' => $entityTypes,
        ]);
    }

    /**
     * Display the specified activity log.
     */
    public function show(ActivityLog $activityLog)
    {
        $activityLog->load('user');
        
        return Inertia::render('activity-logs/show', [
            'activity_log' => $activityLog,
        ]);
    }
}