<?php

namespace App\Http\Controllers;

use App\Model\Presentacion;

class PresentacionController extends Controller
{
    public function index()
    {
        $presentaciones = Presentacion::all();
        $data = [
            "status" => 200,
            "presentaciones" => []
        ];

        foreach ($presentaciones as $presentacion ) {
            array_push($data['presentaciones'], $presentacion);
        }

        return response()->json($data);
    }
}
