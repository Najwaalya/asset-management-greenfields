<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Asset;

class AssetSeeder extends Seeder
{
    public function run(): void
    {
        Asset::create([
            'code' => 'AST-001',
            'name' => 'Laptop ASUS ROG',
            'category_id' => 1,
            'location' => 'Ruang IT',
            'status' => 'normal',
            'description' => 'Laptop untuk development',
            'created_by' => 1,
        ]);

        Asset::create([
            'code' => 'AST-002',
            'name' => 'Printer Epson',
            'category_id' => 2,
            'location' => 'Ruang Admin',
            'status' => 'maintenance',
            'description' => 'Printer kantor',
            'created_by' => 1,
        ]);
    }
}