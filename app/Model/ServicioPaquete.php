<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ServicioPaquete extends Model
{
    protected $table = 'servicio_paquete';
    
    protected $fillable = [
        'id_servicio',
        'id_paquete',
    ];

    public function detalle_paquete()
    {
        return $this->belongsTo('\App\Model\DetallePaquete', 'id_paquete', 'id');
    }

    public function servicio()
    {
        return $this->hasOne('\App\Model\Servicio', 'id', 'id_servicio');
    }
}
