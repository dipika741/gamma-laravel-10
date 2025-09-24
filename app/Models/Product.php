<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'subcategory_id',
        'sub_sub_category_id',
        'name',
        'slug',
        'description',
        'original_price',
        'discount_percentage',
        'discounted_price',
        'rating',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }

    public function subsubcategory()
    {
        return $this->belongsTo(SubsubCategory::class, 'sub_sub_category_id');
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function thumbnail()
    {
        return $this->hasOne(ProductImage::class)->ofMany('id', 'min')->where('is_thumbnail', true);
    }

    public function seoData()
    {
        return $this->hasOne(SeoData::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    /**
     * Get the main image URL (thumbnail or fallback).
     */
    public function getMainImageUrlAttribute()
    {
        if ($this->thumbnail) {
            return $this->thumbnail->url;
        }

        // fallback: first image
        if ($this->images->isNotEmpty()) {
            return $this->images->first()->url;
        }

        // fallback: no image
        return asset('images/no-image.png');
    }
}
