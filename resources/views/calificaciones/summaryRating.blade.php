@extends('layout.master')
@section('content')
<div class="row">

    <div class="col-lg-12  grid-margin stretch-card">
        <div class="card">
        <div class="p-4  bg-light text-center">           
            <h4 class="mb-0  text-primary">Resumen de Calificaciones</h4>
        </div>
        <div class="card-body">
        <div class="col-lg-4 grid-margin stretch-card">
        <strong class="col-lg-5">Periodo :</strong>
        <select class="form-control select2" id="sel_periodSummay" style="width:100%;">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
        </select>                                                                                     
        </div>
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Grados Calificados</h4> 
                    <p class="card-description">Muestra resumen de los grados calificados por el docente {{ Auth::user()->name }}</p> 
                    <div class="table-responsive">
                        <table class="table" id="dt_summaryRating" >
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nombre</th> 
                                    <th>Grupo</th> 
                                    <th>Asignatura</th>
                                    <th>Fecha</th>
                                    <th>Estado</th>
                                    <th></th>
                                </tr>
                            </thead> 
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="mdl_showQualification" tabindex="-1" role="dialog"  aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary   d-block">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>  
        <h4 class="modal-title text-white text-center" >ALUMNOS CALIFICADOS</h4>        
      </div>
      <div class="modal-body">
        
      <div class="row">
                   <div class="container">
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
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>




@endsection
@push('custom-scripts')        
    <script src="{{ asset('/lib/summaryRating.js?v.0') }}"></script>    
@endpush
