<?php

namespace App\Http\Controllers;

use App\Model\Condiciones;
use Illuminate\Http\Request;

class CondicionesController extends Controller
{
    public function index()
    {
        $condiciones = Condiciones::orderBy('id', 'desc')->get();
        $data = [
            "status" => 200,
            "condiciones" => []
        ];

        foreach ($condiciones as $condicion ) {
            array_push($data['condiciones'], $condicion);
        }

        return response()->json($data);
    }
}
