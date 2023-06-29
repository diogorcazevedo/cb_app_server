<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class ProductSubCategory extends Model
{
    protected $table="product_sub_category";
    protected $fillable =[
        'id',
        'product_id',
        'category_id',
        'sub_categories_id',

    ];

    public function category()
    {
        return $this->belongsTo(Category::class);

    }
    public function subcategory()
    {
        return $this->belongsTo(SubCategories::class);

    }
    public function product()
    {
        return $this->belongsTo(Product::class);

    }

}

