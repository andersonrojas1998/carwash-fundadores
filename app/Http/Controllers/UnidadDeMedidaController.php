<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUnidadDeMedida;
use App\Model\UnidadDeMedida;
use Exception;

class UnidadDeMedidaController extends Controller
{
    public function index(){
        $unidades_de_medida = UnidadDeMedida::orderBy('id','desc')->get();
        $data = [
            "status" => 200,
            "unidades_de_medida" => []
        ];

        foreach ($unidades_de_medida as $unidad_de_medida ) {
            array_push($data['unidades_de_medida'], $unidad_de_medida);
        }

        return response()->json($data);
    }

    public function store(StoreUnidadDeMedida $request)
    {

        try{
            $unidad_de_medida = new UnidadDeMedida($request->all());
            $unidad_de_medida->save();

            return response()->json([
                'success' => 'Se ha creado la unidad de medida "' . $unidad_de_medida->nombre . ' (' . $unidad_de_medida->abreviatura . ')" satisfactoriamente.',
                'unidad_de_medida' =>[
                    'id' => $unidad_de_medida->id,
                    'nombre' => $unidad_de_medida->nombre,
                    'abreviatura' => $unidad_de_medida->abreviatura
                ]
            ], 201);
        }catch(Exception $e){
            return response()->json($e->getMessage(), 500);
        }
    }
}
