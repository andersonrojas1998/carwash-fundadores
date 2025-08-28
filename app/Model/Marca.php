<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    protected $table = 'marca';

    protected $fillable = ['nombre'];

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
