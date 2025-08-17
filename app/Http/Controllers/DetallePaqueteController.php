<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDetallePaquete;
use App\Model\DetallePaquete;
use App\Model\Paquete;
use App\Model\Servicio;
use App\Model\ServicioPaquete;
use App\Model\TipoVehiculo;
use Exception;

class DetallePaqueteController extends Controller
{
    public function index()
    {
        $paquetes_carro = Paquete::select('paquete.*')->join(
            'detalle_paquete AS dp',
            'dp.id_paquete',
            'paquete.id')
            ->join(
                'tipo_vehiculo AS tv',
                'tv.id',
                'dp.id_tipo_vehiculo')
            ->where(
                'tv.nomenclatura',
                'C')
            ->orderBy('paquete.nombre')
            ->groupBy('paquete.id')
            ->paginate(4);

        $paquetes_moto = Paquete::select('paquete.*')->join(
            'detalle_paquete AS dp',
            'dp.id_paquete',
            'paquete.id')
            ->join(
                'tipo_vehiculo AS tv',
                'tv.id',
                'dp.id_tipo_vehiculo')
            ->where(
                'tv.nomenclatura',
                'M')
            ->orderBy('paquete.nombre')
            ->groupBy('paquete.id')
            ->paginate('4');

        return view('detalle-paquete.index', compact('paquetes_carro', 'paquetes_moto'));
    }

    public function create()
    {
        $servicios = Servicio::all();
        $paquetes_sin_parametrizar = Paquete::select('paquete.*')
        ->crossJoin(
            'tipo_vehiculo AS tv')
        ->leftJoin(
            'detalle_paquete AS dp',
            [
                ['tv.id','dp.id_tipo_vehiculo'],
                ['dp.id_paquete','paquete.id']
            ])
            ->whereNull('dp.id')
            ->groupBy('paquete.id')
            ->get();

        return view('detalle-paquete.create', compact('paquetes_sin_parametrizar', 'servicios'));
    }

    public function store(StoreDetallePaquete $request)
    {
        try{
            $input = $request->all();
            
            $detalle_paquete = new DetallePaquete($input);
            $detalle_paquete->save();

            $detalles_paquete = DetallePaquete::select("detalle_paquete.*")->join(
                "tipo_vehiculo AS tv",
                "id_tipo_vehiculo",
                "tv.id"
            )->where([
                ["id_paquete", $detalle_paquete->id_paquete],
                ["nomenclatura", $detalle_paquete->tipo_vehiculo->nomenclatura]
            ])->get();

            foreach($detalles_paquete as $det_paquete){
                foreach ($det_paquete->servicio_paquete as $servicio_paquete) {
                    $servicio_paquete->delete();
                }
            }

            foreach($detalles_paquete as $det_paquete){
                foreach($input['id_servicio'] as $id_servicio){
                    $servicio = new ServicioPaquete([
                        'id_servicio' => $id_servicio,
                        "id_paquete" => $det_paquete->id
                    ]);
                    $servicio->save();
                }
            }

            return redirect()->route('detalle-paquete.index')->with('success', 'Se ha creado el combo/servicio ' . $detalle_paquete->paquete->nombre . ' satisfactoriamente.');
        }catch(Exception $e){
            return redirect()->route('detalle-paquete.index')->with('fail', 'Ha ocurrido un error al guardar<br><br>' . $e->getMessage());
        }
    }

    public function edit(DetallePaquete $detalle_paquete)
    {
        $servicios = Servicio::all();
        return view('detalle-paquete.edit', compact('detalle_paquete', 'servicios'));
    }

    public function update(StoreDetallePaquete $request, DetallePaquete $detalle_paquete)
    {
        try{
            $input = $request->all();
            $detalle_paquete->update($input);
            
            $detalles_paquete = DetallePaquete::select("detalle_paquete.*")->join(
                "tipo_vehiculo AS tv",
                "id_tipo_vehiculo",
                "tv.id"
            )->where([
                ["id_paquete", $detalle_paquete->id_paquete],
                ["nomenclatura", $detalle_paquete->tipo_vehiculo->nomenclatura]
            ])->get();

            foreach($detalles_paquete as $det_paquete){
                foreach ($det_paquete->servicio_paquete as $servicio_paquete) {
                    $servicio_paquete->delete();
                }
            }

            foreach($detalles_paquete as $det_paquete){
                foreach($input['id_servicio'] as $id_servicio){
                    $servicio = new ServicioPaquete([
                        'id_servicio' => $id_servicio,
                        "id_paquete" => $det_paquete->id
                    ]);
                    $servicio->save();
                }
            }

            return redirect()->route('detalle-paquete.index')->with('success', 'Se ha modificado el combo/servicio ' . $detalle_paquete->paquete->nombre . ' satisfactoriamente.');
        }catch(Exception $e){
            return redirect()->route('detalle-paquete.index')->with('fail', 'Ha ocurrido un error al guardar<br><br>' . $e->getMessage());
        }
    }

    public function unrelatedVehicleType(Paquete $paquete)
    {
        $tipos_vehiculo = TipoVehiculo::select('tipo_vehiculo.*')
        ->crossJoin('paquete AS p')
        ->leftJoin(
            'detalle_paquete AS dp',
            [
                ['dp.id_tipo_vehiculo', 'tipo_vehiculo.id'],
                ['p.id', 'dp.id_paquete']
            ])
        ->whereNull('dp.id')
        ->where('p.id', $paquete->id)
        ->get();

        $data = [
            "status" => "200",
            "tipos_vehiculo" => []
        ];

        foreach ($tipos_vehiculo as $tipo_vehiculo ) {
            $tipo_vehiculo->img_url = $tipo_vehiculo->imagen;
            array_push($data['tipos_vehiculo'], $tipo_vehiculo);
        }

        return response()->json($data);
    }
}
