<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class ProductGem extends Model
{
    protected $table="product_gem";
    protected $fillable =[
        'id',
        'product_id',
        'gem_id',

    ];


    public function gem()
    {
        return $this->belongsTo(Gem::class);

    }
    public function product()
    {
        return $this->belongsTo(Product::class);

    }

}

