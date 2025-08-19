<?php

namespace App\Http\Controllers;
use App\Model\Clientes;
use Illuminate\Http\Request;

class ClientesController extends Controller
{
    public function index(Request $request)
    {
        $clientes = \App\Model\Clientes::with(['ventas.detalle_paquete.tipo_vehiculo'])->get();

        $data = [];
        foreach ($clientes as $key => $cliente) {
            $ventas = $cliente->ventas;
            $cantidad_servicios = $ventas->count();

            $tipo_vehiculo = '';
            if ($cantidad_servicios > 0) {
                $ultimaVenta = $ventas->last();
                $tipo_vehiculo = $ultimaVenta && $ultimaVenta->detalle_paquete && $ultimaVenta->detalle_paquete->tipo_vehiculo
                    ? $ultimaVenta->detalle_paquete->tipo_vehiculo->descripcion
                    : '';
            }

            $data[] = [
                'no' => $key + 1,
                'nombre_cliente' =>$cliente->nombre,
                'numero_telefono' => $cliente->telefono,
                'placa' =>strtoupper($cliente->placa),
                'tipo_vehiculo' => $tipo_vehiculo,
                'cantidad_servicios' => $cantidad_servicios,
            ];
        }

        if ($request->ajax()) {
            return response()->json(['data' => $data]);
        }

        return view('clientes.index');
    }
}
