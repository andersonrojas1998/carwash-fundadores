<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Loan extends Model
{
    

    protected $table = 'loans';

    protected $fillable = [
        'id_usuario',
        'valor',
        'concepto',
        'fecha_prestamo',
        'fecha_pago',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }
}