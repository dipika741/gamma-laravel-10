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
        
        // mapping subcategory name => subsubcategories
        $map = [
            'Accessories'   => ['Accessories 1 ', 'Accessories 2'],
            'Autoclave Sterilizer' => ['Sterilizer 1', 'Sterilizer 2'],

            'General Laboratory Equipment'   => ['Equipment 1', 'Equipment 2'],
            'Burettes' => ['Burettes 1', 'Burettes 2'],

            'Crucibles' => ['Crucibles 1', 'Crucibles 2'],
            'Disposable Glassware'     => ['Disposable Art', 'Disposable 2'],
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
                    'slug' => Str::slug($ss),
                ]);
            }
        }
            
    }
}
