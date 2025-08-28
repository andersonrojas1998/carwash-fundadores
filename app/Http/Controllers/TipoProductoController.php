<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTipoProducto;
use App\Model\Tipo_Producto;
use Exception;
use Illuminate\Http\Request;

class TipoProductoController extends Controller
{
    public function index(){
        $tipos_producto = Tipo_Producto::all();
        $data = [
            "status" => 200,
            "tipos_productos" => []
        ];

        
        foreach($tipos_producto as $tipo_producto) {
            array_push($data['tipos_productos'], $tipo_producto);
        }
        return response()->json($data);
    }

    public function store(StoreTipoProducto $request){
        try {
            $tipo_producto = new Tipo_Producto($request->all());
            $tipo_producto->save();

            return response()->json([
                'success' => 'Se ha creado el tipo de producto "' . $tipo_producto->descripcion . '" satisfactoriamente.',
                'tipo_producto' => [
                    "id" => $tipo_producto->id,
                    "descripcion" => $tipo_producto->descripcion
                ],
            ], 201);
        } catch (Exception $e) {
            return response()->json($e, 500);
        }
    }
}
