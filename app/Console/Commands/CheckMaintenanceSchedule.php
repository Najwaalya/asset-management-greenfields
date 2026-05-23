<?php

namespace App\Console\Commands;

use App\Models\MaintenanceSchedule;
use Illuminate\Console\Command;

class CheckMaintenanceSchedule extends Command
{
    protected $signature   = 'maintenance:check';
    protected $description = 'Cek jadwal maintenance yang jatuh tempo hari ini';

    public function handle()
    {
        $today = now()->toDateString();

        // Ambil jadwal yang jatuh tempo hari ini & masih upcoming
        $schedules = MaintenanceSchedule::with(['asset', 'assignee'])
            ->where('scheduled_date', $today)
            ->where('status', 'upcoming')
            ->get();

        if ($schedules->isEmpty()) {
            $this->info('Tidak ada jadwal maintenance hari ini.');
            return;
        }

        foreach ($schedules as $schedule) {
            // Update status jadi in_progress
            $schedule->update(['status' => 'in_progress']);

            // Buat maintenance log otomatis
            \App\Models\MaintenanceLog::create([
                'asset_id'    => $schedule->asset_id,
                'schedule_id' => $schedule->id,
                'reported_by' => $schedule->created_by,
                'assigned_to' => $schedule->assigned_to,
                'issue'       => $schedule->description ?? $schedule->title,
                'status'      => 'pending',
            ]);

            $this->info("Jadwal [{$schedule->title}] untuk asset [{$schedule->asset->name}] diproses.");
        }

        $this->info("Total {$schedules->count()} jadwal diproses.");
    }
}