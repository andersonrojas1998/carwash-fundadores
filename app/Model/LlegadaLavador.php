<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class LlegadaLavador extends Model
{
    protected $table = 'llegadas_lavadores';

    protected $fillable = [
        'id_empleado', // id del trabajador
        'hora_llegada',
        'estado', // activo/ocupado
    ];

    public function empleado()
    {
        return $this->belongsTo(\App\User::class, 'id_empleado', 'id');
    }
}