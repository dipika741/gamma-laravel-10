<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ProductImage extends Model
{
    protected $fillable = [
        'product_id',
        'image_path',
        'is_thumbnail',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Boot function to handle automatic file deletion.
     */
    protected static function booted()
    {
        static::deleting(function ($image) {
            if ($image->image_path && Storage::disk('public')->exists($image->image_path)) {
                Storage::disk('public')->delete($image->image_path);
            }
        });
    }

    /**
     * Get full URL for the image (for Blade/frontend usage).
     */
    public function getUrlAttribute()
    {
        return $this->image_path
            ? Storage::url($this->image_path)
            : asset('images/no-image.png'); // fallback image
    }
}
