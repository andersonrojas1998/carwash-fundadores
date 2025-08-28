<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePaquete;
use App\Model\Paquete;
use App\Model\TipoVehiculo;
use Exception;

class PaqueteController extends Controller
{
    public function index()
    {
        $paquetes = Paquete::paginate(12);

        return view('paquete.index', compact('paquetes'));
    }

    public function store(StorePaquete $request)
    {
        try{
            $colors = [
                '#00b0eb,#000000,#ffffff', '#fdf204,#000000,#ffffff', '#a3cc32,#000000,#ffffff',
                '#ed1b26,#ffffff,#ffffff', '#8ed7f8,#000000,#ffffff', '#2d3192,#ffffff,#ffffff',
                '#ffffff,#000000,#000000'
            ];

            $paquete = new Paquete($request->all());
            $paquete->color = $colors[array_rand($colors)];
            $paquete->save();

            return response()->json([
                'success' => 'Se ha creado la paquete "' . $paquete->nombre . '" satisfactoriamente.',
                'paquete' => [
                    'id' => $paquete->id,
                    'nombre' => $paquete->nombre,
                    'url' => route('detalle-paquete.unrelatedVehicleType',[$paquete->id])
                ]
            ], 201);
        }catch(Exception $e){
            return response()->json($e->getMessage(), 500);
        }
    }

    public function packagesByVehicleType(TipoVehiculo $tipoVehiculo)
    {
        $tipoVehiculo->imagen = asset($tipoVehiculo->imagen);

        $paquetes = Paquete::select("paquete.*")
        ->join(
            'detalle_paquete AS dp',
            'dp.id_paquete',
            'paquete.id'
            )->join('tipo_vehiculo AS tv',
            'dp.id_tipo_vehiculo',
            'tv.id'
            )->where(
                'tv.id',
                $tipoVehiculo->id
                )->get();
                
        $data = [
            "status" => "200",
            "paquetes" => []
        ];
        
        foreach ($paquetes as $paquete ) {
            $paquete->precio = $paquete->detalle_paquete->where('id_tipo_vehiculo', $tipoVehiculo->id)->first()->precio_venta;
            $paquete->id_detalle_paquete = $paquete->detalle_paquete->where('id_tipo_vehiculo', $tipoVehiculo->id)->first()->id;
            $paquete->porcentaje = $paquete->detalle_paquete->where('id_tipo_vehiculo', $tipoVehiculo->id)->first()->porcentaje;
            $paquete->tipo_vehiculo = $tipoVehiculo;
            $paquete->servicios_paquete = $paquete->detalle_paquete->where('id_tipo_vehiculo', $tipoVehiculo->id)->first()->servicio_paquete;
            foreach($paquete->servicios_paquete as $servicio_paquete){
                $servicio_paquete->servicio;
            }
            array_push($data['paquetes'], $paquete);
        }

        return response()->json($data);
    }
}
