<?php

namespace App\Http\Controllers;
use DB;
use App\User;
use Auth;
use Request;
class DocenteController extends Controller
{
    public function index(){
        return view('empleados.index_docentes');
    }
    public function index_create(){
        $roles=DB::SELECT("SELECT id,name FROM roles");
        return view('empleados.index_created',compact('roles'));
    }
    public function sales(){
        return view('empleados.index_sales');
    }
   public function dt_user(){
        $dataUs=User::All();        
        $data=[];
        foreach($dataUs as $key => $us)
        {                            
            $data['data'][$key]['con']=$key;   
            $data['data'][$key]['id']=$us->id;
            $data['data'][$key]['dni']=$us->identificacion;
            $data['data'][$key]['name']=$us->name;   
            $data['data'][$key]['celular']=$us->celular;
            $data['data'][$key]['genero']=$us->genero;                         
            $name=[];
            foreach($us->RolesUser as $i=>$v){
                $name[]=$v->rol->name;
            }         
            $data['data'][$key]['cargo']=  implode($name,' - ');
            $data['data'][$key]['estado']=$us->estado;            
        }      
        return json_encode($data);          
    }

    public function dt_sales_user()
    {
        $users = \DB::table('users')->select('id', 'identificacion', 'name')->get();
        $data = [];

        foreach ($users as $key => $user) {
            // Total de servicios
            $cant_servicios = \DB::table('venta')
                ->where('id_usuario', $user->id)
                ->whereNotNull('id_detalle_paquete')
                ->count();

            // Servicios pendientes
            $pendiente = \DB::table('venta')
                ->where('id_usuario', $user->id)
                ->where('id_estado_venta', 1)
                ->whereNotNull('id_detalle_paquete')
                ->count();

            // Pago pendiente
            $pend_pago = \DB::table('venta')
                ->where('id_usuario', $user->id)
                ->where('id_estado_venta', 1)
                ->selectRaw('ROUND(SUM(total_venta * porcentaje_paquete / 100)) as pend_pago')
                ->value('pend_pago');

            // Total préstamos no pagados
            $total_prestamos = \DB::table('loans')
                ->where('id_usuario', $user->id)
                ->whereNull('fecha_pago')
                ->sum('valor');

            // Obtener balance negativo actual
            $balance = \DB::table('employee_balances')->where('user_id', $user->id)->value('saldo');
            $balance = $balance ?? 0;

            // Préstamos nuevos (no pagados)
            $prestamos_nuevos = \DB::table('loans')
                ->where('id_usuario', $user->id)
                ->whereNull('fecha_pago')
                ->sum('valor');

            $data['data'][$key]['con'] = $key;
            $data['data'][$key]['id'] = $user->id;
            $data['data'][$key]['dni'] = $user->identificacion;
            $data['data'][$key]['name'] = $user->name;
            $data['data'][$key]['cant_servicios'] = $cant_servicios;
            $data['data'][$key]['pagos'] = $cant_servicios - $pendiente;
            $data['data'][$key]['pendiente'] = $pendiente;
            $data['data'][$key]['pend_pago'] = is_null($pend_pago) ? 0 : $pend_pago;
            $data['data'][$key]['prestamos'] = $prestamos_nuevos;
            $data['data'][$key]['balance'] = $balance;
        }

        return response()->json($data);
    }

    public function dt_pay_pending($idUser, $status)
    {
        $ventas = \App\Model\Venta::with([
            'cliente',
            'detalle_paquete.paquete',
            'detalle_paquete.tipo_vehiculo'
        ])
        ->where('id_usuario', $idUser)
        ->where('id_estado_venta', $status)
        ->whereNotNull('id_detalle_paquete')
        ->select([
            'id as no_venta',
            'id_cliente',
            'id_detalle_paquete',
            'total_venta',
            'porcentaje_paquete',
            'fecha_pago',
            'fecha'
        ])
        ->get();

        $data = [];
        $total = 0;
        $psale = 0;

        foreach ($ventas as $key => $venta) {
            $detallePaquete = $venta->detalle_paquete;
            $paquete = $detallePaquete ? $detallePaquete->paquete : null;
            $tipoVehiculo = $detallePaquete ? $detallePaquete->tipo_vehiculo : null;

            $precio_venta = $venta->total_venta;
            $porcentaje = $venta->porcentaje_paquete;
            $pago = round($precio_venta * $porcentaje / 100);

            $data['data'][$key]['no_venta'] = $venta->no_venta;
            $data['data'][$key]['nombre_cliente'] = $venta->cliente->nombre;
            $data['data'][$key]['fecha_pago'] = date(
                'Y-m-d h:i A',
                strtotime($status == 2 ? $venta->fecha_pago : $venta->fecha)
            );
            $data['data'][$key]['combo'] = $paquete ? $paquete->nombre : '';
            $data['data'][$key]['vehiculo'] = $tipoVehiculo ? $tipoVehiculo->descripcion : '';
            $data['data'][$key]['precio_venta'] = $precio_venta;
            $data['data'][$key]['porcentaje'] = $porcentaje;
            $data['data'][$key]['pago'] = $pago;

            $total += $pago;
            $psale += $precio_venta;
        }

        // Total préstamos pendientes
        $total_prestamos = \DB::table('loans')
            ->where('id_usuario', $idUser)
            ->whereNull('fecha_pago')
            ->sum('valor');

        // Balance general
        $balance = \DB::table('employee_balances')->where('user_id', $idUser)->value('saldo');

        $data['pay_sales'] = $psale;
        $data['pay'] = $total;
        $data['prestamos'] = $total_prestamos;
        $data['payWithDiscount'] = $total - ($total_prestamos + ($balance < 0 ? abs($balance) : 0));
        $data['balance'] = $balance;

        return response()->json($data);
    }

    public function pay_sales()
    {
        $userId = intval(Request::input('id_usuario'));

        // 1. Total a pagar por ventas pendientes
        $ventas = \DB::table('venta')
            ->where('id_usuario', $userId)
            ->where('id_estado_venta', 1)
            ->whereNotNull('id_detalle_paquete')
            ->get();

        $totalPago = 0;
        foreach ($ventas as $venta) {
            $totalPago += round($venta->total_venta * $venta->porcentaje_paquete / 100);
        }

        // Validar que existan servicios pendientes y saldo a pagar
        if ($ventas->count() == 0 || $totalPago <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'No hay servicios pendientes por pagar o el saldo es cero.'
            ], 400);
        }

        // Balance anterior (puede ser negativo)
        $balance = \DB::table('employee_balances')->where('user_id', $userId)->value('saldo');
        $balance = $balance ?? 0;

        // Préstamos nuevos (no pagados)
        $prestamos = \DB::table('loans')
            ->where('id_usuario', $userId)
            ->whereNull('fecha_pago')
            ->orderBy('fecha_prestamo')
            ->get();

        $totalPrestamos = $prestamos->sum('valor');       
        $saldoFinal = $totalPago + $balance - $totalPrestamos;

        // Si el saldo final es negativo, todos los préstamos quedan pagados y el saldo negativo se actualiza
        if ($saldoFinal < 0) {
            foreach ($prestamos as $prestamo) {
                \DB::table('loans')->where('id', $prestamo->id)->update(['fecha_pago' => now()]);
            }
            \DB::table('employee_balances')->updateOrInsert(
                ['user_id' => $userId],
                ['saldo' => $saldoFinal, 'updated_at' => now()]
            );
        } else {
            // Paga préstamos hasta donde alcance, el resto queda pendiente
            $restante = $totalPago + $balance;
            foreach ($prestamos as $prestamo) {
                if ($restante >= $prestamo->valor) {
                    \DB::table('loans')->where('id', $prestamo->id)->update(['fecha_pago' => now()]);
                    $restante -= $prestamo->valor;
                } else {
                    break;
                }
            }
            // Si ya no hay deuda, elimina el balance
            \DB::table('employee_balances')->where('user_id', $userId)->delete();
        }

        // 6. Marcar ventas como pagadas
        \DB::table('venta')
            ->where('id_usuario', $userId)
            ->where('id_estado_venta', 1)
            ->whereNotNull('id_detalle_paquete')
            ->update([
                'id_estado_venta' => 2,
                'fecha_pago' => now()
            ]);

        return response()->json([
            'success' => true,
            'saldo' => $saldoFinal
        ]);
    }
    

    public function create(){

        $user=User::where('identificacion',Request::input('identificacion'))->get();
        if(!isset($user[0]->id)){
            $id=DB::table('users')->insertGetId([
                'identificacion' =>Request::input('identificacion'),
                'name' => Request::input('name'),
                'email'=>Request::input('email'),
                'password'=> \Hash::make(Request::input('password')),
                'direccion'=>Request::input('direccion'),
                'telefono'=>Request::input('telefono'),
                'celular'=>Request::input('celular'),                
                'fecha_nacimiento'=>date('Y-m-d',strtotime(Request::input('nacimiento'))),
                'lugar_expedicion'=>Request::input('expedicion'),
                'cargo'=>Request::input('cargo'),
                'genero'=>Request::input('genero')                
            ]);
            $user = User::find($id);
            $user->attachRole(Request::input('cargo'));
            return 1;
        }else{
            return 2;
        }
        
    }
    public function update(){
        DB::table('users')
                ->where('id', Request::input('id_user'))
                ->update([
                    'name' => Request::input('nombre'),
                    'email' => Request::input('email'),
                    'direccion' => Request::input('direccion'),
                    'telefono' => Request::input('telefono'),
                    'celular' => Request::input('celular'),
                    'fecha_nacimiento' => date('Y-m-d',strtotime(Request::input('nacimiento'))),
                    'lugar_expedicion'=>Request::input('expedicion'),
                    'genero'=>Request::input('genero'),
                    'estado'=>Request::input('estado')
                    ]
            );
            return 1;
    }
    public function showUser($id){
        return json_encode(User::find($id));
    }

    // Nueva función para retornar préstamos no pagados de un empleado
    public function loans_by_user($id)
    {
        $loans = \DB::table('loans')
            ->where('id_usuario', $id)
            ->whereNull('fecha_pago')
            ->select('valor', 'concepto', 'fecha_prestamo')
            ->get();

        return response()->json($loans);
    }
}
