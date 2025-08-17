<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVenta;
use App\Model\DetalleCompraProductos;
use App\Model\DetalleVentaProductos;
use App\Model\Producto;
use App\Model\TipoVehiculo;
use App\Model\users;
use App\Model\Venta;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;


class VentaController extends Controller
{
    public function index()
    {
        $ventas =  Venta::orderBy('id','desc')->get()->take(500);
        $usuarios = users::select("users.*")->join("roles as r", "cargo", "r.id")->where("r.slug", "Lavador")->get();
        return view('venta.index', compact('ventas','usuarios'));
    }

    public function create()
    {
        $tipos_vehiculo = TipoVehiculo::all();
        $date = Carbon::now();
        $date->setTimezone('America/Bogota');
        $productos=DB::SELECT("CALL sp_products('1,2')  ");
        $usuarios = users::select("users.*")->join("roles as r", "cargo", "r.id")->where("r.slug", "Lavador")->get();
        return view('venta.create', compact('tipos_vehiculo', 'date', 'productos', 'usuarios'));
    }

    public function createMarket()
    {
        $date = Carbon::now();
        $date->setTimezone('America/Bogota');
        $productos = DetalleCompraProductos::select(DB::raw("*, cast(if((detalle_compra_productos.cantidad-(SELECT sum(cantidad) FROM detalle_venta_productos AS dvp WHERE detalle_compra_productos.id_detalle_compra = dvp.id_detalle_producto)) is null, detalle_compra_productos.cantidad, (detalle_compra_productos.cantidad-(SELECT sum(cantidad) FROM detalle_venta_productos AS dvp WHERE detalle_compra_productos.id_detalle_compra = dvp.id_detalle_producto))) AS unsigned) cantidad_disponible"))->join("producto as p", "p.id", "detalle_compra_productos.id_producto")->where("id_area","3")->get()->where('cantidad_disponible', '>', 0);
        $usuarios = users::select("users.*")->join("roles as r", "cargo", "r.id")->where("r.slug", "Tienda")->get();
        return view('venta.create_market', compact('date', 'productos', 'usuarios'));
    }

    public function store(StoreVenta $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->all();

            // Validar datos de cliente
            $nombre_cliente = trim($data['nombre_cliente'] ?? '');
            $placa = trim($data['placa'] ?? '');
            $numero_telefono = trim($data['numero_telefono'] ?? '');

            if (!$nombre_cliente || !$placa) {
                return redirect()->back()->with('fail', 'Debe ingresar nombre y placa del cliente.');
            }

            // Buscar cliente por nombre y placa
            $cliente = \App\Model\Clientes::where('nombre', $nombre_cliente)
                ->where('placa', $placa)
                ->first();

            // Si no existe, crear cliente
            if (!$cliente) {
                $cliente = new \App\Model\Clientes();
                $cliente->nombre = $nombre_cliente;
                $cliente->placa = $placa;
                $cliente->telefono = $numero_telefono;
                $cliente->save();
            }

            if (empty($data['id_producto']) && empty($data['id_detalle_paquete'])) {
                return redirect()->back()->with('fail', 'Por favor diligenciar los campos correspondientes.');
            }

            $status = (isset($data['id_producto']) && !isset($data['id_detalle_paquete'])) ? 3 : 1;

            $venta = new Venta($data);
            $venta->fecha = now()->setTimezone('America/Bogota');
            $venta->id_estado_venta = $status;
            $venta->total_venta = floatval($data['importe_total']);
            $venta->precio_venta_paquete = isset($data['precio_venta_paquete']) ? floatval($data['precio_venta_paquete']) : 0;
            $venta->porcentaje_paquete = isset($data['porcentaje_paquete']) ? intval($data['porcentaje_paquete']) : 0;
            $venta->id_cliente = $cliente->id; // Guardar el id_cliente
            $venta->save();

            if (!empty($data['id_producto'])) {
                foreach ($data['id_producto'] as $key => $id_producto) {
                    $prd = intval($id_producto);
                    $stock = DB::select("CALL sp_sell_prd_stock('$prd')");
                    $solicitado = intval($data['cantidad'][$key]);
                    $pricesale = floatval($data['precio_venta'][$key]);
                    $restante = $solicitado;

                    foreach ($stock as $st) {
                        $cantidadbd = intval($st->restante);
                        $cantidad_a_vender = min($restante, $cantidadbd);

                        if ($cantidad_a_vender > 0) {
                            $detalle_venta_producto = new DetalleVentaProductos([
                                "id_detalle_producto" => $st->id_detalle_compra,
                                "id_venta" => $venta->id,
                                "cantidad" => $cantidad_a_vender,
                                "precio_venta" => $pricesale,
                                "margen_ganancia" => $pricesale - $st->precio_compra,
                            ]);
                            $detalle_venta_producto->save();
                            $restante -= $cantidad_a_vender;
                        }

                        if ($restante <= 0) {
                            break;
                        }
                    }
                }
            }

            DB::commit();
            return redirect()->route('venta.show', [$venta->id])->with('success', 'Se ha registrado la venta satisfactoriamente');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('venta.index')->with('fail', 'Ha ocurrido un error al guardar<br><br>' . $e->getMessage());
        }
    }

    public function edit($id_venta)
    {
        $tipos_vehiculo = TipoVehiculo::all();
        $venta=Venta::find($id_venta);
        return view('venta.edit', compact('tipos_vehiculo','venta'));
    }


    public function updateUser(){
       
            DB::table('venta')
            ->where('id', intval(\Request::input('id_venta')))            
            ->update([
                'id_usuario' =>intval(\Request::input('id_user'))                         
                ]
        );
        return 1;



    }


    public function update(Request $request)
    {
       
        
        try{
            $venta=Venta::find(intval($request->all()['id_venta']));            
            $venta->id_detalle_paquete= intval($request->all()['id_detalle_paquete']);              
            $venta->total_venta= floatval($request->all()['importe_total']);
            $venta->precio_venta_paquete= (isset($request->all()['precio_venta_paquete']))? floatval($request->all()['precio_venta_paquete']):0;            
            $venta->porcentaje_paquete= (isset($request->all()['porcentaje_paquete']))?  intval($request->all()['porcentaje_paquete']):0;
            $venta->save();                   
            
            return redirect()->route('venta.show', [intval($request->all()['id_venta'])])->with('success', 'Se ha modificado la venta satisfactoriamente');

        }catch(Exception $e){
            return redirect()->route('compra.index')->with('fail', 'Ha ocurrido un error al guardar<br><br>' . $e->getMessage());
        }
    }

    public function show(Venta $venta)
    {
        
        $productos=DB::SELECT("CALL sp_groupSalesProduct('$venta->id')  ");         
        return view("venta.show", compact('venta','productos'));
    }
    public function showCopy($ventas)
    {
        $venta = Venta::find($ventas);
        $productos=DB::SELECT("CALL sp_groupSalesProduct('$venta->id')  ");         

        return view("venta.showCopy", compact('venta','productos'));
    }
    public function buscarClientePlaca(Request $request)
    {
        $placa =$request->input('placa');
        $cliente = \App\Model\Clientes::where('placa', $placa)->first();

        if ($cliente) {
            return response()->json([
                'success' => true,
                'cliente' => [
                    'nombre_cliente' => $cliente->nombre,
                    'numero_telefono' => $cliente->telefono
                ]
            ]);
        } else {
            return response()->json(['success' => false]);
        }
    }
}
