<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;


class Productcopy extends Model
{
    use HasFactory;
    protected $fillable = [
        'category_id', 'subcategory_id', 'subsubcategory_id',
        'name', 'description', 'original_price',
        'discount_percentage', 'discounted_price', 'rating'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }

    public function subSubCategory()
{
    return $this->belongsTo(SubSubCategory::class, 'sub_sub_category_id');
}


    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }
    

    // ✅ Relationship to SEO data
    public function seoData()
    {
        return $this->hasOne(SeoData::class);
    }
    
    public function thumbnail()
    {
        return $this->hasOne(ProductImage::class)->where('is_thumbnail', true);
    }   

    public static function booted()
{
    static::deleting(function ($product) {
        foreach ($product->images as $image) {
            if ($image->image_path && Storage::exists($image->image_path)) {
                Storage::delete($image->image_path);
            }
        }
    });
}

}
