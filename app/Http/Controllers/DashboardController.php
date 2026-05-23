<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\MaintenanceLog;
use App\Models\User;
use App\Models\MaintenanceSchedule;

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
        $logEvents = MaintenanceLog::with('asset')
            ->get()
            ->map(fn($log) => [
                'id'     => $log->id,
                'date'   => $log->created_at->format('Y-m-d'),
                'title'  => $log->asset->name ?? '-',
                'status' => $log->status, // pending, in_progress, resolved
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