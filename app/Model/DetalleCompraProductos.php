<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class DetalleCompraProductos extends Model
{
    protected $table = "detalle_compra_productos";

    protected $primaryKey = "id_detalle_compra";

    protected $fillable = [
        'id_producto',
        'id_compra',
        'cantidad',
        'precio_compra',
        'precio_venta'
    ];

    public function producto()
    {
        return $this->hasOne('App\Model\Producto', 'id', 'id_producto');
    }

    public function compra(){
        return $this->belongsTo('App\Model\Compra', 'id');
    }
}
