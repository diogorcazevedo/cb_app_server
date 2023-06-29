<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StockOut extends Model
{

    use SoftDeletes;


    protected $table = 'product_stock_out';

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'product_id',
        'quantity',
        'unit_price',
        'out_price',
        'pack',
        'taxes',
        'frete',
        'extras',
        'order_item_id',
        'unit_cost',
        'income',

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
