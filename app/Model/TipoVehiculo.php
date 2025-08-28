<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TipoVehiculo extends Model
{
    protected $table = "tipo_vehiculo";

    protected $fillable = [
        'descripcion',
        'imagen_url'
    ];

    public function detalle_paquete()
    {
        return $this->belongsTo('App\Model\DetallePaquete', 'id');
    }
}
