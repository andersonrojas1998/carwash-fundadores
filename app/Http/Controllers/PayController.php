<?php

namespace App\Http\Controllers;
use App\Model\Compra;
use Illuminate\Http\Request;

class PayController extends Controller
{



    public function store(Request $request)
    {
        try{           
            $compra = new Compra($request->all());
            $compra->condiciones_id = 1;
            $compra->estado_id=2;
            $compra->save();
            return redirect()->route('compra.index')->with('success', 'Se ha creado la compra satisfactoriamente');
        }catch(Exception $e){
            return redirect()->route('compra.index')->with('fail', 'Ha ocurrido un error al guardar<br><br>' . $e->getMessage());
        }
    }

}
