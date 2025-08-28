<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Presentacion extends Model
{
    protected $table = "presentacion";

    public function producto()
    {
        return $this->belongsTo('App\Model\Producto', 'id', 'id_presentacion');
    }
}
