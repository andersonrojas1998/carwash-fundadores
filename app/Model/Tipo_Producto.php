<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Tipo_Producto extends Model
{
    protected $table = 'tipo_producto';

    protected $fillable = ['descripcion'];

    public function getDescripcionAttribute($value){
        return ucfirst($value);
    }

    public function setDescripcionAttribute($value)
    {
        $this->attributes['descripcion'] = strtolower($value);
    }
}
