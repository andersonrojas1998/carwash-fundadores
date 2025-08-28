<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreServicio;
use App\Model\Servicio;
use App\Model\TipoVehiculo;
use Exception;

class ServicioController extends Controller
{
    public function index()
    {
        $servicios = Servicio::orderBy('nombre')->get();
        
        return view('servicio.index', compact('servicios'));
    }

    public function create()
    {
        $tipos_vehiculo = TipoVehiculo::all();
        return view('servicio.create', compact('tipos_vehiculo'));
    }

    public function store(StoreServicio $request)
    {
        try{
            $input = $request->all();
            $servicio = new Servicio($input);
            $servicio->save();

            $input['id_servicio'] = $servicio->id;

            return redirect()->route('servicio.index')->with('success', 'Se ha creado el servicio "' . $servicio->nombre . '" satisfactoriamente.');
        }catch(Exception $e){
            return redirect()->route('servicio.index')->with('fail', 'Ha ocurrido un error al guardar<br><br>' . $e->getMessage());
        }
    }

    public function edit(Servicio $servicio)
    {
        $tipos_vehiculo = TipoVehiculo::all();
        return view('servicio.edit', compact('servicio', 'tipos_vehiculo'));
    }
    
    public function update(StoreServicio $request, Servicio $servicio)
    {
        try{
            $servicio->update($request->all());

            return redirect()->route('servicio.index')->with('success', 'Se ha modificado el servicio "' . $servicio->nombre . '" satisfactoriamente.');
        }catch(Exception $e){
            return redirect()->route('servicio.index')->with('fail', 'Ha ocurrido un error al guardar<br><br>' . $e->getMessage());
        }
    }

    /*public function getServicesByVehicleType(TipoVehiculo $tipo_vehiculo)
    {
        $servicios_tipo_vehiculo = ServicioTipoVehiculo::where('id_tipo_vehiculo', $tipo_vehiculo->id)->get();
        foreach ($servicios_tipo_vehiculo as $servicio_tipo_vehiculo ) {
            $servicio_tipo_vehiculo->servicio;
        }
        return response()->json($servicios_tipo_vehiculo);
    }*/
}
