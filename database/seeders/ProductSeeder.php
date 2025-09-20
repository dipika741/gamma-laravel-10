<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Product;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\SubSubCategory;
use Faker\Factory as Faker;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    { /*
        $faker = Faker::create();

        // Get all categories, subcategories, sub-subcategories
        $categories = Category::all();
        $subcategories = Subcategory::all();
        $subsubcategories = SubSubCategory::all();

        if ($categories->isEmpty()) {
            $this->command->info('No categories found. Seed categories first!');
            return;
        }

        // Create 50 products
        for ($i = 0; $i < 50; $i++) {
            $category = $categories->random();

            $subcategoryCollection = $subcategories->where('category_id', $category->id);
            $subcategory = $subcategoryCollection->isNotEmpty() ? $subcategoryCollection->random() : null;

            $subsubCollection = $subsubcategories->where('subcategory_id', $subcategory?->id);
            $subsub = $subsubCollection->isNotEmpty() ? $subsubCollection->random() : null;

            $originalPrice = $faker->randomFloat(2, 100, 5000);
            $discountPercentage = $faker->numberBetween(0, 50);
            $discountedPrice = $originalPrice - ($originalPrice * $discountPercentage / 100);

            Product::create([
                'category_id' => $category->id,
                'subcategory_id' => $subcategory?->id,
                'sub_sub_category_id' => $subsub?->id,
                'name' => $faker->unique()->words(3, true),
                'title' => $faker->sentence(),
                'description' => $faker->paragraph(),
                'original_price' => $originalPrice,
                'discount_percentage' => $discountPercentage,
                'discounted_price' => $discountedPrice,
                'rating' => $faker->randomFloat(1, 0, 5),
                'slug' => Str::slug($faker->unique()->words(3, true)),
            ]);
        }

        $this->command->info('50 products seeded successfully!');
        */
    }
}
