<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stock extends Model
{

    use SoftDeletes;


    protected $table = 'product_stock';

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'product_id',
        'quantity',
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


    public function getOfferedPriceAttribute($value)
    {

     //   $pctm = 15.00;
      //  $value = $value - ($value / 100 * $pctm);
        return $value ;
    }
    /*

         public $preventAttrSet = true;

    public function getOfferedPriceAttribute($value) {
        if ($this->preventAttrSet) {
            $pctm = 15.00;
            $value = $value - ($value / 100 * $pctm);
            return $value;
        } else {
            return $value;
        }
    }
     */

}
