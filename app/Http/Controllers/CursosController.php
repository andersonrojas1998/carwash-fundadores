<?php

namespace App\Http\Controllers;
use Request;
use DB;
use App\Model\curso;
class CursosController extends Controller
{
    public function index(){        
        return view('curso.index_curso');
    }
    public function listCourse($grade){
        $anio=date('Y');
        $c=DB::SELECT("CALL sp_courseForGrade('$grade','$anio') ");
        $data=[];
        foreach($c as $k=> $vl){
            $data['data'][$k]['id']=$vl->id;
            $data['data'][$k]['grado']=$vl->grado;
            $data['data'][$k]['docente']=$vl->name;
            $data['data'][$k]['asignatura']=$vl->asignatura;
            $data['data'][$k]['ih']=$vl->intensidad_horaria;            
        }
        return json_encode($data);
    }
    public function addCourseGrade(){
        $grado=curso::where('id_grado',Request::input('id_grado'))->where('id_materia',Request::input('id_materia'))->get();
        if(!isset($grado[0]->id)){
             DB::table('curso')->insert([
                'id_grado' =>Request::input('id_grado'),
                'id_docente' => Request::input('id_docente'),
                'id_materia'=>Request::input('id_materia'),
                'año'=> date('Y'),
                'intensidad_horaria'=>Request::input('ih'),                
            ]);
            return 1;
        }else{
            return 2;
        }


    }
}
