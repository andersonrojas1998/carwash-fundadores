<?php
namespace App\Http\Controllers;

use App\Model\LlegadaLavador;
use App\User;
use Illuminate\Http\Request;

class LlegadaLavadorController extends Controller
{
    public function index()
    {
        $hoy = date('Y-m-d');
        $llegadas = LlegadaLavador::whereDate('hora_llegada', $hoy)
            ->with('empleado')
            ->orderBy('orden', 'asc')
            ->get();

        // Obtener los IDs de empleados que ya llegaron hoy
        $empleadosLlegadosIds = $llegadas->pluck('id_empleado')->toArray();

        // Listar empleados que NO están en la lista de llegadas
        $empleados = User::whereNotIn('id', $empleadosLlegadosIds)->get();

        return view('empleados.checkin-employe', compact('llegadas', 'empleados'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_empleado' => 'required|exists:users,id',
            'hora_llegada' => 'required'
        ]);

        // Obtener el máximo orden actual para hoy
        $hoy = date('Y-m-d');
        $maxOrden = LlegadaLavador::whereDate('hora_llegada', $hoy)->max('orden');
        $nuevoOrden = is_null($maxOrden) ? 1 : $maxOrden + 1;

        LlegadaLavador::create([
            'id_empleado' => $request->id_empleado,
            'hora_llegada' => $hoy . ' ' . $request->hora_llegada,
            'estado' => 'activo',
            'orden' => $nuevoOrden
        ]);

        return response()->json(['success' => true]);
    }

    public function cambiarEstado(Request $request)
    {
        $llegada = LlegadaLavador::find($request->id);
        if ($llegada) {
            $llegada->estado = $request->estado;

            // Si se reactiva, lo manda al final de la cola
            if ($request->estado === 'activo') {
                $hoy = date('Y-m-d');
                $maxOrden = LlegadaLavador::whereDate('hora_llegada', $hoy)->max('orden');
                $llegada->orden = is_null($maxOrden) ? 1 : $maxOrden + 1;
            }

            $llegada->save();
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false]);
    }
}