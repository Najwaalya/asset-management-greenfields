<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Asset;

class AssetSeeder extends Seeder
{
    public function run(): void
    {
        $assets = [
            // Laptop (category_id: 1)
            ['code' => 'AST-001', 'name' => 'Laptop ASUS ROG',        'category_id' => 1, 'location' => 'Ruang IT',       'status' => 'normal',      'description' => 'Laptop development tim IT'],
            ['code' => 'AST-002', 'name' => 'Laptop Dell Latitude',   'category_id' => 1, 'location' => 'Ruang HRD',      'status' => 'normal',      'description' => 'Laptop HRD'],
            ['code' => 'AST-003', 'name' => 'Laptop Lenovo ThinkPad', 'category_id' => 1, 'location' => 'Ruang Keuangan', 'status' => 'maintenance', 'description' => 'Laptop keuangan, sedang servis'],
            ['code' => 'AST-004', 'name' => 'Laptop HP EliteBook',    'category_id' => 1, 'location' => 'Ruang Direksi',  'status' => 'normal',      'description' => 'Laptop direktur'],

            // Printer (category_id: 2)
            ['code' => 'AST-005', 'name' => 'Printer Epson L3150',    'category_id' => 2, 'location' => 'Ruang Admin',    'status' => 'maintenance', 'description' => 'Printer admin utama'],
            ['code' => 'AST-006', 'name' => 'Printer Canon G2010',    'category_id' => 2, 'location' => 'Ruang HRD',      'status' => 'normal',      'description' => 'Printer HRD'],
            ['code' => 'AST-007', 'name' => 'Printer HP LaserJet',    'category_id' => 2, 'location' => 'Ruang Keuangan', 'status' => 'broken',       'description' => 'Printer laser keuangan, broken'],

            // Monitor (category_id: 3)
            ['code' => 'AST-008', 'name' => 'Monitor LG 24"',         'category_id' => 3, 'location' => 'Ruang IT',       'status' => 'normal',      'description' => 'Monitor tambahan IT'],
            ['code' => 'AST-009', 'name' => 'Monitor Samsung 27"',    'category_id' => 3, 'location' => 'Ruang Direksi',  'status' => 'normal',      'description' => 'Monitor direksi'],

            // Projector (category_id: 5)
            ['code' => 'AST-010', 'name' => 'Projector Epson EB-X41', 'category_id' => 5, 'location' => 'Ruang Rapat A',  'status' => 'normal',      'description' => 'Projector rapat lantai 1'],
            ['code' => 'AST-011', 'name' => 'Projector BenQ MX825ST', 'category_id' => 5, 'location' => 'Ruang Rapat B',  'status' => 'maintenance', 'description' => 'Projector rapat lantai 2'],

            // Server (category_id: 6)
            ['code' => 'AST-012', 'name' => 'Server Dell PowerEdge',  'category_id' => 6, 'location' => 'Server Room',    'status' => 'normal',      'description' => 'Server utama aplikasi'],
            ['code' => 'AST-013', 'name' => 'Server HP ProLiant',     'category_id' => 6, 'location' => 'Server Room',    'status' => 'normal',      'description' => 'Server backup'],

            // UPS (category_id: 8)
            ['code' => 'AST-014', 'name' => 'UPS APC 1500VA',         'category_id' => 8, 'location' => 'Server Room',    'status' => 'normal',      'description' => 'UPS server room'],
            ['code' => 'AST-015', 'name' => 'UPS Eaton 650VA',        'category_id' => 8, 'location' => 'Ruang IT',       'status' => 'broken',       'description' => 'UPS ruang IT, perlu penggantian baterai'],
        ];

        foreach ($assets as $asset) {
            Asset::create(array_merge($asset, ['created_by' => 1]));
        }
    }
}