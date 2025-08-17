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

    public function dt_sales_user(){
        $dataUs=DB::SELECT("CALL sp_salesxuser()");        
        $data=[];
        foreach($dataUs as $key => $us)
        {                            
            $data['data'][$key]['con']=$key;   
            $data['data'][$key]['id']=$us->id_user;
            $data['data'][$key]['dni']=$us->identificacion;
            $data['data'][$key]['name']=$us->name; 
            $data['data'][$key]['cant_servicios']=$us->cant_servicios;
            $data['data'][$key]['pagos']=($us->cant_servicios-$us->pendiente); 
            $data['data'][$key]['pendiente']=$us->pendiente; 
            $data['data'][$key]['pend_pago']= (is_null($us->pend_pago))? 0:$us->pend_pago;
           
                       
        }
        return json_encode($data);          
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
            'precio_venta_paquete',
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

            $precio_venta = $venta->precio_venta_paquete;
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

        $data['pay_sales'] = $psale;
        $data['pay'] = $total;

        return response()->json($data);
    }

    public function pay_sales(){        
        DB::table('venta')
                ->where('id_usuario', intval(Request::input('id_usuario')))
                ->where('id_estado_venta', 1)
                ->whereNotNull('id_detalle_paquete')
                ->update([
                    'id_estado_venta' =>2,
                    'fecha_pago' =>date('Y-m-d h:i:s')                    
                    ]
            );
            return 1;
    }
    

    public function create(){

        $user=User::where('identificacion',Request::input('identificacion'))->get();
        if(!isset($user[0]->id)){
            $id=DB::table('users')->insertGetId([
                'identificacion' =>Request::input('identificacion'),
                'name' => Request::input('name'),
                'email'=>Request::input('email'),
                'password'=> \Hash::make('123456'),
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
}
