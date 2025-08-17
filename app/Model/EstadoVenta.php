<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class EstadoVenta extends Model
{
    protected $table = 'estado_venta';

    public function venta()
    {
        return $this->belongsTo('\App\Model\Venta', 'id', 'id_estado_venta');
    }
}
