<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubsubCategory extends Model
{
    protected $fillable = ['category_id', 'subcategory_id', 'name', 'slug'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subcategory()
    {
        return $this->belongsTo(SubCategory::class);
    }

    public function products()
{
    return $this->hasMany(Product::class, 'sub_sub_category_id');
}

}

