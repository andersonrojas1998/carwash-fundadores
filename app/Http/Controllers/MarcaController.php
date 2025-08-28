<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMarca;
use App\Model\Marca;
use Exception;

class MarcaController extends Controller
{
    public function index(){
        $marcas = Marca::all();
        $data = [
            "status" => "200",
            "marcas" => []
        ];

        foreach ($marcas as $marca ) {
            array_push($data['marcas'], $marca);
        }

        return response()->json($data);
    }

    public function store(StoreMarca $request){
        try{
            $marca = new Marca($request->all());
            $marca->save();

            return response()->json([
                'success' => 'Se ha creado la marca "' . $marca->nombre . '" satisfactoriamente.',
                'marca' => [
                    'id' => $marca->id,
                    'nombre' => $marca->nombre
                ]
            ], 201);
        }catch(Exception $e){
            return response()->json($e->getMessage(), 500);
        }
    }
}