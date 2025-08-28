<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'producto';

    protected $fillable = ['nombre','id_marca','id_tipo_producto', 'id_unidad_medida', 'id_presentacion', 'id_area','precio_venta'];

    public function compras(){
    	return $this->hasMany('App\Model\DetalleCompraProductos','id_producto','id');
    }

    public function marca(){
        return $this->hasOne('App\Model\Marca','id','id_marca');        
    }

    public function tipo_producto()
    {
        return $this->hasOne('App\Model\Tipo_Producto', 'id', 'id_tipo_producto');
    }

    public function unidad_medida()
    {
        return $this->hasOne('App\Model\UnidadDeMedida', 'id', 'id_unidad_medida');
    }

    public function presentacion()
    {
        return $this->hasOne('App\Model\Presentacion', 'id', 'id_presentacion');
    }
}
