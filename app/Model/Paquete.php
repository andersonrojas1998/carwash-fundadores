<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Paquete extends Model
{
    protected $table = 'paquete';

    protected $fillable = [
        'nombre',
        'color'
    ];

    public function getNombreAttribute($value)
    {
        return ucfirst(strtolower($value));
    }

    public function setNombreAttribute($value)
    {
        $this->attributes['nombre'] = strtolower($value);
    }

    public function detalle_paquete()
    {
        return $this->hasMany('\App\Model\DetallePaquete', 'id_paquete', 'id');
    }
}
