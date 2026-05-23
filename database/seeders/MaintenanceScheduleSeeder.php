<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MaintenanceSchedule;

class MaintenanceScheduleSeeder extends Seeder
{
    public function run(): void
    {
        $schedules = [
            // Jadwal upcoming
            [
                'asset_id'       => 1,
                'created_by'     => 1,
                'assigned_to'    => 1,
                'title'          => 'Servis Rutin Laptop ASUS ROG',
                'description'    => 'Pembersihan debu, cek kondisi baterai, update driver',
                'scheduled_date' => now()->addDays(3),
                'repeat_every'   => 90,
                'next_schedule'  => now()->addDays(3 + 90),
                'status'         => 'upcoming',
            ],
            [
                'asset_id'       => 5,
                'created_by'     => 1,
                'assigned_to'    => 1,
                'title'          => 'Perawatan Printer Epson L3150',
                'description'    => 'Head cleaning, cek level tinta, test print',
                'scheduled_date' => now()->addDays(1),
                'repeat_every'   => 30,
                'next_schedule'  => now()->addDays(31),
                'status'         => 'upcoming',
            ],
            [
                'asset_id'       => 12,
                'created_by'     => 1,
                'assigned_to'    => 1,
                'title'          => 'Maintenance Server Dell PowerEdge',
                'description'    => 'Cek log error, backup data, update patch OS',
                'scheduled_date' => now()->addDays(7),
                'repeat_every'   => 30,
                'next_schedule'  => now()->addDays(37),
                'status'         => 'upcoming',
            ],
            [
                'asset_id'       => 10,
                'created_by'     => 1,
                'assigned_to'    => 2,
                'title'          => 'Cek Projector Ruang Rapat A',
                'description'    => 'Bersihkan lensa, cek jam pemakaian lampu, kalibrasi warna',
                'scheduled_date' => now()->addDays(14),
                'repeat_every'   => 60,
                'next_schedule'  => now()->addDays(74),
                'status'         => 'upcoming',
            ],
            [
                'asset_id'       => 14,
                'created_by'     => 1,
                'assigned_to'    => 2,
                'title'          => 'Pengecekan UPS APC 1500VA',
                'description'    => 'Test baterai, cek runtime, bersihkan filter udara',
                'scheduled_date' => now()->addDays(5),
                'repeat_every'   => 180,
                'next_schedule'  => now()->addDays(185),
                'status'         => 'upcoming',
            ],

            // Jadwal in_progress
            [
                'asset_id'       => 3,
                'created_by'     => 1,
                'assigned_to'    => 1,
                'title'          => 'Servis Laptop Lenovo ThinkPad',
                'description'    => 'Install ulang OS, upgrade storage ke SSD',
                'scheduled_date' => now()->subDays(1),
                'repeat_every'   => null,
                'next_schedule'  => null,
                'status'         => 'in_progress',
            ],
            [
                'asset_id'       => 11,
                'created_by'     => 1,
                'assigned_to'    => 2,
                'title'          => 'Perbaikan Projector BenQ MX825ST',
                'description'    => 'Ganti lampu projector, bersihkan filter',
                'scheduled_date' => now(),
                'repeat_every'   => null,
                'next_schedule'  => null,
                'status'         => 'in_progress',
            ],

            // Jadwal done
            [
                'asset_id'       => 13,
                'created_by'     => 1,
                'assigned_to'    => 1,
                'title'          => 'Maintenance Server HP ProLiant',
                'description'    => 'Cek RAID, pembersihan debu, update firmware',
                'scheduled_date' => now()->subDays(15),
                'repeat_every'   => 30,
                'next_schedule'  => now()->addDays(15),
                'status'         => 'done',
            ],
            [
                'asset_id'       => 6,
                'created_by'     => 1,
                'assigned_to'    => 2,
                'title'          => 'Servis Rutin Printer Canon G2010',
                'description'    => 'Head cleaning, isi ulang tinta',
                'scheduled_date' => now()->subDays(20),
                'repeat_every'   => 30,
                'next_schedule'  => now()->addDays(10),
                'status'         => 'done',
            ],
            [
                'asset_id'       => 8,
                'created_by'     => 1,
                'assigned_to'    => 2,
                'title'          => 'Cek Monitor LG 24"',
                'description'    => 'Kalibrasi warna, bersihkan layar',
                'scheduled_date' => now()->subDays(30),
                'repeat_every'   => 90,
                'next_schedule'  => now()->addDays(60),
                'status'         => 'done',
            ],

            // Jadwal cancelled
            [
                'asset_id'       => 2,
                'created_by'     => 1,
                'assigned_to'    => null,
                'title'          => 'Perawatan Laptop Dell Latitude',
                'description'    => 'Jadwal dibatalkan karena teknisi tidak tersedia',
                'scheduled_date' => now()->subDays(10),
                'repeat_every'   => null,
                'next_schedule'  => null,
                'status'         => 'cancelled',
            ],
            [
                'asset_id'       => 9,
                'created_by'     => 1,
                'assigned_to'    => null,
                'title'          => 'Servis Monitor Samsung 27"',
                'description'    => 'Dibatalkan, monitor masih dalam kondisi baik',
                'scheduled_date' => now()->subDays(5),
                'repeat_every'   => null,
                'next_schedule'  => null,
                'status'         => 'cancelled',
            ],
        ];

        foreach ($schedules as $schedule) {
            MaintenanceSchedule::create($schedule);
        }
    }
}