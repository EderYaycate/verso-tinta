<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PedidoItem extends Model
{
    protected $fillable = ['pedido_id', 'libro_id', 'cantidad', 'precio'];

    public function libro()
    {
        return $this->belongsTo(Libro::class);
    }

    public function pedido()
    {
        return $this->belongsTo(Pedido::class);
    }
}