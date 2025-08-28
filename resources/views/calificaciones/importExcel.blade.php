@extends('layout.master')
@section('content')
<div class="row">

<div class="col-lg-12  grid-margin stretch-card">
        <div class="card">
        <div class="p-4  bg-light text-center ">           
                <h4 class="mb-0">Administraci&oacute;n de calificaciones</h4>                
        </div>
            <div class="card-body">
            <div class="row">
            <p class="text-capitalize">Por favor adjutar el  formato de planilla de nota  correspondiente por cada grupo asignado</p>           
            </div> 
            
            
<div class="callout callout-warning pnl-close-period" style="display:none;">
  <h4>ATENCI&Oacute;N</h4>
  <div class="txt-call"></div>
  <p class="text-danger">Por favor comuniquese con el administrador del sistema para que habilite el periodo.</p>
</div>
<br>

<div class="row">
<div class="col-lg-3">
            <strong>Periodo : <span class="text-danger">*</span></strong>
                <select class="form-control select2"  id="sel_perid" style="width:100%" >
                <option value="">Seleccione..</option>
                <option value="1">1P</option>
                <option value="2">2P</option>
                <option value="3">3P</option>
                </select>                  
            </div>
</div>
<br>
<div class="row pnl-load" style="display:none;">
        <div class="col-lg-6">
            <form enctype="multipart/form-data" id="formExcelLoad"  method="post" >
            <meta name="csrf-token" content="{{ csrf_token() }}">                          
                <label>Plantilla: </label>
                    <div class="file-loading">
                        <input  name="file" id="fileExcelLoad" type="file" >
                    </div>                                                                         
                    </form>
        </div>
        <div class="col-lg-2">
        <button type="button" id="loadExcel" data-toggle="tooltip" data-placement="top" data-title="Recuerda ingresar las notas con puntos  Ej: 5.0 " class="btn btn-success btn-fw">Cargar <i class="mdi mdi-file-excel"></i></button>
        </div>


        </div>
        </div>  
        <br>
        </div>
</div>


    <div class="col-lg-12  grid-margin stretch-card pnl-load" style="display:none;">
        <div class="card">
        <div class="p-4  bg-light ">           
            <h4 class="mb-0  text-primary">Resumen Calificaci&oacute;n</h4>
        </div>
        <div class="card-body">
            <div class="row">
                   <div class="col-lg-12">
                   <table class="table table-bordered table-hover table-striped" id="dt_qualificationsPeriod" style="width:100%;">
                            <thead>
                                <tr class="text-center">
                                <th colspan="7" class="bg-secondary">PLANILLA DE EVALUACI&Oacute;N</th>
                                </tr>        
                                <tr class="text-center">
                                    <th colspan="4"></th>
                                    <th colspan="3" >Periodo</th>                
                                </tr>
                            <tr class="text-center">
                                <th>#</th>
                                <th>Matricula</th>
                                <th>Alumno</th>
                                <th>Grado</th>            
                                <th>1</th>
                                <th>2</th>
                                <th>3</th>            
                            </tr>        
                        </thead>
                    </table>   
                   </div>                 
            </div>
            </div>
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