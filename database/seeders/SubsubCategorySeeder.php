<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Subcategory;
use App\Models\SubsubCategory;
use Illuminate\Support\Str;

class SubsubCategorySeeder extends Seeder
{
    public function run(): void
    {
        /*
        // mapping subcategory name => subsubcategories
        $map = [
            'Mobiles'   => ['Smartphones', 'Feature Phones'],
            'Computers' => ['Laptops', 'Desktops'],

            'Men'   => ['Shirts', 'Trousers'],
            'Women' => ['Dresses', 'Skirts'],

            'Furniture' => ['Sofas', 'Beds'],
            'Decor'     => ['Wall Art', 'Vases'],
        ];

        foreach ($map as $subName => $subsubs) {
            $subcategory = Subcategory::where('name', $subName)->first();
            if (!$subcategory) {
                continue;
            }

            foreach ($subsubs as $ss) {
                SubsubCategory::create([
                    'subcategory_id' => $subcategory->id,
                    'category_id' => $subcategory->category_id ?? null,
                    'name' => $ss,
                ]);
            }
        }
            */
    }
}
