<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\MaintenanceLog;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalAssets = Asset::count();
        $normalAssets = Asset::where('status', 'normal')->count();
        $maintenanceAssets = Asset::where('status', 'maintenance')->count();
        $brokenAssets = Asset::where('status', 'broken')->count();

        // Alerts dengan level
        $recentAlerts = MaintenanceLog::with(['asset'])
            ->whereIn('status', ['pending', 'in_progress'])
            ->orWhereHas('asset', fn($q) => $q->where('status', 'broken'))
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($log) {
                $log->alert_level = match(true) {
                    $log->asset?->status === 'broken' => 'critical',
                    $log->status === 'in_progress'    => 'info',
                    default                           => 'warning',
                };
                return $log;
            });

        // Calendar events
        $calendarEvents = MaintenanceLog::with(['asset'])
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->get()
            ->map(fn($log) => [
                'id'     => $log->id,
                'title'  => $log->asset->name ?? '-',
                'date'   => $log->created_at->format('Y-m-d'),
                'status' => $log->status,
            ]);

        $recentMaintenances = MaintenanceLog::with(['asset'])
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.index', compact(
            'totalAssets', 'normalAssets', 'maintenanceAssets', 'brokenAssets',
            'recentAlerts', 'calendarEvents', 'recentMaintenances'
        ));
    }
}