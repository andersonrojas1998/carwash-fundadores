<?php
namespace App\Http\Controllers;
use DB;
use DateTime;
use Auth;
use Request;
use App\Model\EgresosMensuales;
use App\Model\EgresosConcepto;


class ReportsController extends Controller
{

    public  $firstDay,$lastDay;

    public function __construct(){
        $date = new DateTime();
        $this->firstDay =$date->modify('first day of this month')->format('Y-m-d');
        $this->lastDay = $date->modify('last day of  this month')->format('Y-m-d');        
    }

    public function index(){        
        return view('reports.index_qualify');
    }

    public function index_income_expeses(){        
        return view('reports.index_income_expenses');
    }

    public function index_sales_month_day(){        
        return view('reports.index_sales_month_day');
    }
    public function index_month_utility(){        
        return view('reports.index_month_utility');
    }
    public function getReportApproved($period,$grade){

        $readTmp=DB::SELECT("CALL sp_missedSubjects('$period','$grade')  ");

        $data=[];
        foreach($readTmp as $k=> $v){
           $data['asignatura'][$k]=$v->tag;
           $data['perdidas'][$k]= $v->perdidas;
           $data['aprovadas'][$k]=$v->aprovadas;
        }
        return json_encode($data);
    }

    public function getSalesxMonth(){

       $data=[];
        for ($i=1;$i<=12;$i++){
            $readTmp=DB::SELECT("CALL sp_salesxmonth('$i')  ");            
            $data[]=$readTmp[0]->cantidadxmes;
            
        }      
        return json_encode($data);
    }
    public function getSalesxDay(){                
        $lastDay=date('d',strtotime('last day of this month', time()));
        $data=[];
        for($i=1;$i<=$lastDay;$i++){
            
            $readTmp=DB::SELECT("CALL sp_salesxday('$i')  ");            
            $data['cantidad'][$i]=$readTmp[0]->cantidadxdia;
            $data['label'][$i]=$i;
        }       
       return json_encode($data);
     }


     public function getUtilityMonth(){

        $data=[];
         for ($i=1;$i<=12;$i++){
             $readTmp=DB::SELECT("CALL sp_expenses_month('$i')  ");
             $tt=floatval($readTmp[0]->egreso+$readTmp[0]->nomina);
             
             $e=is_null($tt)? 0: $tt;  
             $data['expenses'][$i]= $e;

             
             $service=DB::SELECT("CALL sp_incomexservice('$i')  ");              
             $product=DB::SELECT("CALL sp_incomexproduct('$i')  "); 

             $s=is_null($product[0]->gananciasxproducto)? 0:floatval($product[0]->gananciasxproducto);
             $p=is_null($service[0]->gananciasxservicio)? 0: floatval($service[0]->gananciasxservicio);
             $data['income'][$i]=$s+$p;
         }      
         return json_encode($data);
     }
     public function chart_income_service(){
        $d=date('m');
        $product=DB::SELECT("CALL sp_incomexproduct('$d')  ");            
        $service=DB::SELECT("CALL sp_incomexservice('$d')  ");            
        
        $data=[];
        $data['product']= is_null($product[0]->gananciasxproducto)? 0:floatval($product[0]->gananciasxproducto);
        $data['service']=is_null($service[0]->gananciasxservicio)? 0: floatval($service[0]->gananciasxservicio);
        $data['total']=number_format(floatval($service[0]->gananciasxservicio)+floatval($product[0]->gananciasxproducto),0,',','.');
              
       return json_encode($data);
     }

     public function income_store($ini,$end){
       
       $dateini=date('Y-m-d',strtotime($ini));
       $dateend=date('Y-m-d',strtotime($end) );
       $product=DB::SELECT("CALL sp_incomexproduct_day('$dateini','$dateend')  ");            
        $service=DB::SELECT("CALL sp_incomexservice_day('$dateini','$dateend')  ");   
        
        $salett=DB::SELECT("CALL sp_incomexsales('$dateini','$dateend')  ");                    
        $data=[];
        
        

        $data['tt_prd']=  number_format(is_null($salett[0]->total_venta )? 0:floatval($salett[0]->total_venta ),0,',','.');
        $data['tt_prd_qq']=  is_null($salett[0]->cantidad )? 0:floatval($salett[0]->cantidad );
        $data['product']= number_format(is_null($product[0]->gananciasxproducto)? 0:floatval($product[0]->gananciasxproducto) ,0,',','.') ;
        $data['service']=number_format(is_null($service[0]->gananciasxservicio)? 0: floatval($service[0]->gananciasxservicio),0,',','.') ;
        $data['total']=number_format(floatval($service[0]->gananciasxservicio)+floatval($product[0]->gananciasxproducto),0,',','.');
              
       return json_encode($data);
     }

     public function dt_expenses_month(){    
        $d=date('m');    
        $expenses=DB::SELECT("CALL sp_expenses('$d')  ");                 
        $data=[];
        $i=0;
        $total=0;
        foreach($expenses as $key=> $v){
            $data['data'][$key]['no']=$i++;
            $data['data'][$key]['concepto']= $v->concepto;
            $data['data'][$key]['valor']=number_format($v->egreso,0,',','.');
            $total+=$v->egreso;
        }
        $data['total']= $total;
        return json_encode($data);       
     }
     public function add_expenses(){

     
        $obj= new EgresosMensuales();
        $obj->fecha=date('Y-m-d');
        $obj->id_concepto= intval(Request::input('id_concepto'));
        $obj->total_egreso=intval(Request::input('total_egreso'));        
        $obj->save();
        return 1;
     }

    public function concept_expenses(){

        return json_encode(EgresosConcepto::all());
    }

    public function sales_summary($ini, $end)
    {
        $dateini = date('Y-m-d', strtotime($ini));
        $dateend = date('Y-m-d', strtotime($end));

        // Ventas por día
        $ventasPorDia = DB::table('venta')
            ->select(DB::raw("DATE(fecha) as dia"), DB::raw("COUNT(*) as cantidad"), DB::raw("SUM(total_venta) as total"))
            ->whereBetween(DB::raw('DATE(fecha)'), [$dateini, $dateend])
            ->groupBy(DB::raw("DATE(fecha)"))
            ->orderBy('dia')
            ->get();

        // Ventas discriminadas por medio de pago
        $ventasPorMedio = DB::table('venta')
            ->select('medio_pago', DB::raw('SUM(total_venta) as total'), DB::raw('COUNT(*) as cantidad'))
            ->whereBetween(DB::raw('DATE(fecha)'), [$dateini, $dateend])
            ->groupBy('medio_pago')
            ->get();

        // Ventas totales
        $ventasTotales = DB::table('venta')
            ->select(DB::raw('SUM(total_venta) as total'), DB::raw('COUNT(*) as cantidad'))
            ->whereBetween(DB::raw('DATE(fecha)'), [$dateini, $dateend])
            ->first();

        // Loans (préstamos/descuentos) realizados en el periodo, con nombre de usuario
        $loans = DB::table('loans')
            ->join('users', 'loans.id_usuario', '=', 'users.id')
            ->select('loans.id', 'loans.id_usuario', 'users.name as empleado', 'loans.valor', 'loans.concepto', 'loans.fecha_prestamo')
            ->whereBetween(DB::raw('DATE(loans.fecha_prestamo)'), [$dateini, $dateend])
            ->get();
        $totalLoans = $loans->sum('valor');

        // Resumen por día para gráfico
        $dias = [];
        $montos = [];
        foreach ($ventasPorDia as $v) {
            $dias[] = $v->dia;
            $montos[] = $v->total;
        }

        // Medios de pago
        $medios = [
            'efectivo' => 0,
            'transferencia' => 0,
            'pendiente_pago' => 0,
            'Otro' => 0
        ];
        foreach ($ventasPorMedio as $v) {
            if (isset($medios[$v->medio_pago])) {
                $medios[$v->medio_pago] = $v->total;
            } else {
                $medios['Otro'] += $v->total;
            }
        }

        return response()->json([
            'ventas_por_dia' => $ventasPorDia,
            'ventas_totales' => $ventasTotales,
            'ventas_por_medio' => $medios,
            'dias' => $dias,
            'montos' => $montos,
            'loans' => $loans,
            'total_loans' => $totalLoans,
        ]);
    }
     

     
}
