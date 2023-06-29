<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Centro extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'id','name','alias', 'legal_entity_id','main'
    ];


    public function orders()
    {
        return $this->hasMany(Order::class, 'centro');
    }
    public function legal_entity()
    {
        return $this->morphOne(LegalEntity::class, 'legal_entityable');
    }

    public function stocks_minimos()
    {
        return $this->hasMany(StockMinimo::class, 'centro_id');
    }

    //many to many
    public function documents()
    {
        return $this->morphToMany(Document::class, 'documentable');
    }

    public function images()
    {
        return $this->morphToMany(Image::class, 'imageable');
    }


    public function video()
    {
        return $this->morphToMany(Video::class, 'videoable');
    }


    //one to many
    public function addresses()
    {
        return $this->morphMany(Address::class, 'addressable');
    }
    //one to many
    public function contacts()
    {
        return $this->morphMany(Contact::class, 'contactable');
    }

    public function scopeOfCentroStock($query)
    {

        return $query->whereHas('centro_quantidade', function ($query) {

        });

    }

    public function scopeOfCentroStockin($query)
    {

        return $query->whereHas('centro_quantidade', function ($query) {
            $query->where('quantidade','>','0');
        });

    }

    public function products()
    {
        return $this->hasMany(ProductCentro::class);
    }

}
