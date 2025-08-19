<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Clientes extends Model
{
    protected $table="clientes";


    public function ventas()
{
    return $this->hasMany(\App\Model\Venta::class, 'id_cliente', 'id');
}
}