<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Order extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'user_id',
        'total',
        'canal',
        'origem',
        'vendedor',
        'operador',
        'status',
        'credito',
        'comissao',
        'desconto',
        'data',
        'pagamento',
        'parcelamento',
        'centro',
        'comissao_gestao',
        'notafiscal',
        'obs',
        'mes',
        'ano',
        'message',
        'tipo_entrega',
        'entregue',
        'cod_retorno',
        'previsao',
    ];



    public function user()
    {
        return $this->belongsTo(User::class);

    }

    public function sigepe()
    {
        return $this->hasMany(OrderSigepe::class);

    }
    public function ponto()
    {
        return $this->belongsTo(Centro::class,'centro','id');

    }
    public function entregas()
    {
        return $this->hasMany(OrderEntregas::class);
    }
    public function items()
    {
        return $this->hasMany(OrderItems::class);
    }


}
