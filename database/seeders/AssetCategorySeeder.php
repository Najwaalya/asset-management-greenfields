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
        ];

        foreach ($categories as $category) {
            AssetCategory::create([
                'name' => $category
            ]);
        }
    }
}