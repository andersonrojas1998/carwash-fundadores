<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UnidadDeMedida extends Model
{
    protected $table = 'unidad_medida';

    protected $fillable = ['nombre', 'abreviatura'];

    protected $attributes = [
        'estado' => 1
    ];

    public function getNombreAttribute($value)
    {
        return ucfirst($value);
    }

    public function setNombreAttribute($value)
    {
        $this->attributes['nombre'] = strtolower($value);
    }
}
