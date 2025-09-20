<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeoData extends Model
{
    use HasFactory;
    protected $fillable = ['product_id','meta_title','meta_description','meta_keywords'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
