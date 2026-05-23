<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MaintenanceLog;

class MaintenanceLogSeeder extends Seeder
{
    public function run(): void
    {
        $logs = [
            [
                'asset_id'    => 5,
                'reported_by' => 2,
                'issue'       => 'Printer tidak bisa mencetak, hasil print bergaris',
                'solution'    => 'Cleaning head dan ganti cartridge warna',
                'status'      => 'resolved',
                'resolved_at' => now()->subDays(10),
            ],
            [
                'asset_id'    => 7,
                'reported_by' => 2,
                'issue'       => 'Printer laser tidak menyala sama sekali',
                'solution'    => null,
                'status'      => 'pending',
                'resolved_at' => null,
            ],
            [
                'asset_id'    => 3,
                'reported_by' => 2,
                'issue'       => 'Laptop lemot, sering hang saat membuka banyak aplikasi',
                'solution'    => 'Upgrade RAM dari 8GB ke 16GB dan install ulang OS',
                'status'      => 'resolved',
                'resolved_at' => now()->subDays(5),
            ],
            [
                'asset_id'    => 11,
                'reported_by' => 2,
                'issue'       => 'Gambar projector buram dan warna tidak akurat',
                'solution'    => null,
                'status'      => 'in_progress',
                'resolved_at' => null,
            ],
            [
                'asset_id'    => 15,
                'reported_by' => 3,
                'issue'       => 'UPS berbunyi terus, baterai tidak bisa menyimpan daya',
                'solution'    => null,
                'status'      => 'pending',
                'resolved_at' => null,
            ],
            [
                'asset_id'    => 12,
                'reported_by' => 3,
                'issue'       => 'Server panas berlebih, fan berbunyi keras',
                'solution'    => 'Bersihkan debu dan ganti thermal paste processor',
                'status'      => 'resolved',
                'resolved_at' => now()->subDays(2),
            ],
            [
                'asset_id'    => 1,
                'reported_by' => 2,
                'issue'       => 'Keyboard laptop beberapa tombol tidak berfungsi',
                'solution'    => 'Ganti keyboard unit',
                'status'      => 'resolved',
                'resolved_at' => now()->subDays(15),
            ],
        ];

        foreach ($logs as $log) {
            MaintenanceLog::create($log);
        }
    }
}