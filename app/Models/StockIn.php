<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StockIn extends Model
{

    use SoftDeletes;


    protected $table = 'product_stock_in';

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'product_id',
        'quantity',
        'unit_cost',
        'in_cost',
        'offered_price',

    ];

    public function getRouteKeyName()
    {
        return 'id';
    }

    public function product()
    {
        return $this->belongsTo(Product::class);

    }

}
