<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\SubsubCategory;
use App\Models\ProductImage;
use App\Models\SeoData;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        $categories = Category::with('subcategories.subsubcategories')->get();

        $productCount = 50;

        for ($i = 1; $i <= $productCount; $i++) {

            // Pick a random category
            $category = $categories->random();

            // Pick a random subcategory if exists
            $subcategory = $category->subcategories->count() ? $category->subcategories->random() : null;

            // Pick a random subsub if exists
            $subsub = null;
            if ($subcategory && $subcategory->subsubcategories->count()) {
                $subsub = $subcategory->subsubcategories->random();
            }

            // Prices and discount
            $original_price = $faker->numberBetween(50, 5000);
            $discount_percentage = $faker->numberBetween(0, 20);
            $discounted_price = $original_price - ($original_price * $discount_percentage / 100);

            // Product name
            $name = $faker->words(3, true);

            // Create product
            $product = Product::create([
                'category_id' => $category->id,
                'subcategory_id' => $subcategory->id ?? null,
                'sub_sub_category_id' => $subsub->id ?? null,
                'name' => $name,
                'title' => ucfirst($name),
                'description' => $faker->paragraph,
                'original_price' => $original_price,
                'discount_percentage' => $discount_percentage,
                'discounted_price' => $discounted_price,
                'rating' => $faker->randomFloat(1, 0, 5),
                'slug' => Str::slug($name . '-' . $i),
            ]);

            // Add 1–3 images
            $imageCount = $faker->numberBetween(1, 3);
            for ($j = 1; $j <= $imageCount; $j++) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => "products/product_{$i}_{$j}.jpg",
                    'is_thumbnail' => $j === 1,
                ]);
            }

            // Add SEO data
            SeoData::create([
                'product_id' => $product->id,
                'meta_title' => ucfirst($name) . " - " . $category->name,
                'meta_description' => $faker->sentence,
                'meta_keywords' => implode(',', $faker->words(5)),
            ]);
        }
    }
}
