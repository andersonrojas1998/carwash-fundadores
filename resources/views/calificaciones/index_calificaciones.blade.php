@extends('layout.master')
@section('content')
<div class="card">
<div class="p-3  bg-light ">                   
        <div class="card-title  text-center mb-0 display-1" style="font-size:20px;" ><h4>Administraci&oacute;n de calificaciones</h4></div>  
</div>
    <div class="card-body">



<div class="callout callout-warning pnl-close-period" style="display:none;">
  <h4>ATENCI&Oacute;N</h4>
  <div class="txt-call"></div>
  <p class="text-danger">Por favor comuniquese con el administrador del sistema para que habilite el periodo.</p>
</div>


    <div class="row mt-5">
            <div class="col-lg-3">
            <strong>Docente : </strong>
                <input type="text" class="form-control" readonly value="{{ Auth::user()->name }}">
                <input type="hidden" id="idUser" value="{{ Auth::user()->id }}">               
            </div>

            <div class="col-lg-2">
            <strong>Grados : <span class="text-danger">*</span></strong>
                <select class="form-control" name="sel_grades" id="sel_grades" style="width:100%" >
                <option value=""></option>
                </select>                  
            </div>

            <div class="col-lg-2">
            <strong>Asignatura : <span class="text-danger">*</span></strong>
                <select class="form-control" name="sel_course" id="sel_course" style="width:100%" >
                <option value=""></option>
                </select>                  
            </div>

            <div class="col-lg-2">
            <strong>Periodo : <span class="text-danger">*</span></strong>
                <select class="form-control select2" name="sel_perid" id="sel_perid" style="width:100%" >
                <option value="">Seleccione..</option>
                <option value="1">1P</option>
                <option value="2">2P</option>
                <option value="3">3P</option>
                </select>                  
            </div>

            <div class="col-lg-2">
                <button type="button" data-toggle="tooltip" data-placement="top" data-title="Recuerda ingresar las notas con puntos  Ej: 5.0 " id="btn_qualify" class="btn btn-primary btn-rounded btn-fw  btn-qualification">Calificar <i class="mdi mdi-account-star"></i></button>
            </div>
    </div>  

<br><br>

<div class="d-flex flex-row-reverse bd-highlight " >
            <div class="p-2 bd-highlight pnl-load" style="display:none"><div class="dropdown">
            <button  type="button" id="dropdownMenuButton5" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-success dropdown-toggle  btn-qualification"> Descargar </button>
            <div aria-labelledby="dropdownMenuButton5" class="dropdown-menu"   >
            <h6 class="dropdown-header">opciones descarga</h6> 
            <div class="dropdown-divider"></div>
            <a id="generateExcel" class="dropdown-item"><i class="mdi mdi-file-excel text-success"></i> Excel  </a>
            </div></div></div>            
        </div>
<div class="table-responsive pnl-load" style="display:none">  
<meta name="csrf-token" content="{{ csrf_token() }}">
<table class="table table-bordered table-hover table-striped" id="dt_qualifications" style="width:100%;">
        <thead>
            <tr class="text-center">
            <th colspan="23" class="bg-secondary">PLANILLA DE EVALUACI&Oacute;N</th>
            </tr>        
            <tr class="text-center">
                <th colspan="4"></th>
                <th colspan="3" >Periodo</th>
                <th colspan="4" >Interpretativa</th>
                <th colspan="3" >Argum</th>
                <th colspan="3" >Propo</th>
                <th colspan="3" >Social</th>                
                <th colspan="2" >AutoE</th>
                <th>Def</th>
            </tr>
        <tr>
            <th>#</th>
            <th>Matricula</th>
            <th>Alumno</th>
            <th>Grado</th>            
            <th>1</th>
            <th>2</th>
            <th>3</th>

            <th>1</th>
            <th>2</th>
            <th>3</th>
            <th>4</th>

            <th>1</th>
            <th>2</th>
            <th>3</th>

            <th>1</th>
            <th>2</th>
            <th>3</th>

            <th>1</th>
            <th>2</th>
            <th>3</th>


            <th>1</th>
            <th>2</th>
            <th></th>
            
        </tr>        
    </thead>
</table>
</div>

<div class="row pnl-load" style="display:none">
<div class="col-lg-6 offset-3 p-5"><button id="btn-save-qualifications-online" class="btn btn-success btn-block btn-rounded" data-toggle="tooltip" data-placement="top" data-title="CALIFICAR GRADO">GUARDAR</button></div>
</div>

    </div>  
    </div>      
@endsection
@push('custom-scripts')    
    <script src="{{ asset('/lib/qualification.js') }}"></script>    
@endpush
@push('style')
<style>
.callout {
  padding: 20px;
  margin: 20px 0;
  border: 1px solid #eee;
  border-left-width: 5px;
  border-radius: 3px;
  h4 {
    margin-top: 0;
    margin-bottom: 5px;
  }
  p:last-child {
    margin-bottom: 0;
  }
  code {
    border-radius: 3px;
  }
  & + .bs-callout {
    margin-top: -5px;
  }
}
  .callout-warning {
    border-left-color: #f0ad4e;
    h4 {
      color:#f0ad4e !important ;
    }
  }

</style>
@endpush
