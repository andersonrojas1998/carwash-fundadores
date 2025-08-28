<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    protected $table = 'servicio';

    protected $fillable = [
        'nombre'
    ];

    public function servicio_paquete()
    {
        return $this->belongsTo('App\Model\ServicioPaquete', 'id', 'id_servicio');
    }
}
