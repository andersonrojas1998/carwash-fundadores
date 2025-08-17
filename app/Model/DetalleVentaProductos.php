<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class DetalleVentaProductos extends Model
{
    protected $table = 'detalle_venta_productos';

    protected $fillable = [
        'id_venta',
        'id_detalle_producto',
        'cantidad',
        'precio_venta',
        'margen_ganancia'
    ];

    public function venta()
    {
        return $this->hasOne('App\Model\Venta', 'id', 'id_venta');
    }

    public function detalle_compra_productos()
    {
        return $this->hasOne('App\Model\DetalleCompraProductos', 'id_detalle_compra', 'id_detalle_producto');
    }
}
