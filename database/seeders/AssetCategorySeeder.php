<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AssetCategory;

class AssetCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Laptop',
            'Printer',
            'Monitor',
            'Keyboard',
            'Projector',
            'Server',
            'Switch / Router',
            'UPS',
            'Scanner',
            'Telepon / VOIP',
        ];

        foreach ($categories as $category) {
            AssetCategory::create(['name' => $category]);
        }
    }
}