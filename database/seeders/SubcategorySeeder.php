<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Support\Str;

class SubcategorySeeder extends Seeder
{
    public function run(): void
    {
        // mapping parent category name => subcategories
        $map = [
            'Analytical Equipment' => ['Accessories', 'Benchtop Meters','Chemical Test Kits','Electrodes and Probes','Magnetic Stirrers','Photometers','Portable Meters','Refracto meters','Reagents','Refractometers','Refractometers','Thermometers','Titrators','Turbidimeters'],
            'Laboratory Equipment'     => ['Autoclave Sterilizer','Block Heater','Centrifuge','Circulation Bath','Climatic Chamber','Cold Trap Bath','Growth Chamber','Homogenizer','Hotplate Stirrer','Incubator','Laboratory Refrigerator','Muffle Furnacee','Orbital Reciprocal Shaker','Oven','Overhead Stirrer','Rocker','Safety Cabinet','Shaking Incubator'],
            'Material Testing Equipment' => ['Aggregate Rock Testing Equipments', 'Bitumen And Asphalt Testing Equipments','Cement And Mortar Testing Equipment','Concrete Testing Equipment','Material Testing Accessories','Material Testing Tools','Mould','Steel Testing Equipment'],
            'Laboratory Glasswares' => ['Burettes','Crucibles','Disposable Glassware','Glass Dessicators','Glass Dishes','Glass Disposable Culture Tubes','Glass Joints','Glass Measuring Cylinders','Glass Petri Dishes','Glass Pipettes','Glass Reagent Bottles','Glass Tubes','Glassware Flasks','Lab Filtration Assembly','Lab Glassware Brushes','Laboratory Beakers','Laboratory Glass Bottles','Laboratory Glass Columns','Laboratory Glass Condensers','Laboratory Glass Dishes','Laboratory Glassware Adapter'],
            'Laboratory Plasticwares' => ['General Laboratory Equipment','Laboratory Plasticware']
        ];

        foreach ($map as $catName => $subs) {
            $category = Category::where('name', $catName)->first();
            if (!$category) {
                continue;
            }

            foreach ($subs as $subName) {
                Subcategory::create([
                    'category_id' => $category->id,
                    'name' => $subName,
                    'slug' => Str::slug($subName),
                ]);
            }
        }
    }
}
