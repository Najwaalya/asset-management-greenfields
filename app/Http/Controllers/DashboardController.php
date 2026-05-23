<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\MaintenanceLog;
use App\Models\MaintenanceSchedule;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Stat cards
        $totalAssets       = Asset::count();
        $normalAssets      = Asset::where('status', 'normal')->count();
        $maintenanceAssets = Asset::where('status', 'maintenance')->count();
        $brokenAssets      = Asset::where('status', 'broken')->count();

        // Recent maintenance — semua status, diurutkan pending dulu
        $recentMaintenances = MaintenanceLog::with(['asset', 'reporter'])
            ->orderByRaw("CASE
                WHEN status = 'pending'     THEN 1
                WHEN status = 'in_progress' THEN 2
                WHEN status = 'resolved'    THEN 3
            END")
            ->latest()
            ->take(10)
            ->get();

        // Priority alerts — log yang pending atau in_progress
        $recentAlerts = MaintenanceLog::with('asset')
            ->whereIn('status', ['pending', 'in_progress'])
            ->latest()
            ->take(10)
            ->get()
            ->map(function ($log) {
                $log->alert_level = match($log->status) {
                    'pending'     => 'warning',
                    'in_progress' => 'info',
                    default       => 'info',
                };
                return $log;
            });

        // Calendar events — gabungan log & schedule
        $logEvents = MaintenanceLog::with('asset')
            ->get()
            ->map(fn($log) => [
                'id'     => $log->id,
                'date'   => $log->created_at->format('Y-m-d'),
                'title'  => $log->asset->name ?? '-',
                'status' => $log->status,
                'type'   => 'log',
            ]);

        $scheduleEvents = MaintenanceSchedule::with('asset')
            ->get()
            ->map(fn($s) => [
                'id'     => $s->id,
                'date'   => $s->scheduled_date->format('Y-m-d'),
                'title'  => $s->title,
                'status' => match($s->status) {
                    'upcoming'    => 'pending',
                    'in_progress' => 'in_progress',
                    'done'        => 'resolved',
                    default       => 'pending',
                },
                'type'   => 'schedule',
            ]);

        $calendarEvents = $logEvents->merge($scheduleEvents)->values();

        return view('dashboard.index', compact(
            'totalAssets',
            'normalAssets',
            'maintenanceAssets',
            'brokenAssets',
            'recentMaintenances',
            'recentAlerts',
            'calendarEvents',
        ));
    }
}