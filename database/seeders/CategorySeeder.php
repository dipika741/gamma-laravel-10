<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Laboratory Equipment',
            'Analytical Instruments',
            'Material Testing Equipment',
            'HPLC Consumables',
            'Laboratory Glasswares',
            'Laboratory Plasticwares',
            'Laboratory Furnitures',
            'Food Testing Equipment',
        ];

        foreach ($categories as $name) {
            Category::create([
                'name' => $name,
            ]);
        }
    }
}
