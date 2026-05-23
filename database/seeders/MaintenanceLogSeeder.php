<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MaintenanceLog;

class MaintenanceLogSeeder extends Seeder
{
    public function run(): void
    {
        MaintenanceLog::create([
            'asset_id' => 2,
            'reported_by' => 2,
            'issue' => 'Printer tidak bisa mencetak',
            'solution' => 'Ganti cartridge',
            'status' => 'resolved',
            'resolved_at' => now(),
        ]);
    }
}