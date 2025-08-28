<?php

namespace App\Http\Controllers;

use App\Model\Estado;
use Illuminate\Http\Request;

class EstadoController extends Controller
{
    public function index()
    {
        $estados = Estado::orderBy('id_estado', 'desc')->get();

        $data = [
            "status" => 200,
            "estados" => []
        ];

        foreach ($estados as $estado) {
            array_push($data['estados'], $estado);
        }

        return response()->json($data);
    }
}
