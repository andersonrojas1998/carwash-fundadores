<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
    protected $table = 'estado';

    public function compra()
    {
        return $this->belongsTo('App\Model\Compra', 'id');
    }
}
