<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class DetallePaquete extends Model
{
    protected $table = 'detalle_paquete';

    protected $fillable = [
        'precio_venta',
        'porcentaje',
        'id_tipo_vehiculo',
        'id_paquete'
    ];

    public function paquete()
    {
        return $this->hasOne('\App\Model\Paquete', 'id', 'id_paquete');
    }

    public function servicio_paquete()
    {
        return $this->hasMany('\App\Model\ServicioPaquete', 'id_paquete', 'id');
    }

    public function tipo_vehiculo()
    {
        return $this->hasOne('\App\Model\TipoVehiculo', 'id', 'id_tipo_vehiculo');
    }
}
