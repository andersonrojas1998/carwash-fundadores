@extends('layout.master')
@section('content')
<div class="card">
<div class="p-4  bg-light text-center">        
        <h4 class="mb-0">Administraci&oacute;n de Egresos y Ingresos Mensuales</h4>        
</div>
    <div class="card-body">  
        
    <div class="row">

    <div class="col-lg-6 grid-margin stretch-card">            
        <div class="card">
            <div class="card-body">
            <div class="p-4 pr-5 border-bottom bg-light  text-center">
        <h4 class="card-title mb-0 text-center">Egresos Registrados   </h4>        
       </div>            
             <div class="table-responsive pt-5">
                <table id="dt_expenses_month" class="table table-striped">
                <thead>
                    <tr>
                        <th> # </th> 
                        <th>Concepto</th>                         
                        <th>Valor</th></tr>                
                </thead>                 
            </table>
            </div>
            </div> 
            <div class="card-footer">
            <input type="hidden" id="inp_hd_total_inc">
              <input type="hidden" id="inp_hd_total_exp">
              
            <label>Total Egresos : <h3 class="text-danger" id="total_exp"></h3></label>
            </div>          
        </div>
    </div>
    <div class="col-lg-6 grid-margin stretch-card">
    <div class="card">
      <div class="p-4 pr-5 border-bottom bg-light d-sm-flex justify-content-between">
        <h4 class="card-title mb-0">Ingresos por Ventas (Servicios/Productos)</h4>
        <div id="pie-chart-legend" class="mr-4"></div>
      </div>
      <div class="card-body d-flex">
        <canvas class="my-auto" id="chart_income_service" height="130"></canvas>
      </div>
      <div class="card-footer">
        <div class="row">
          <div class="col-lg-6"><label>Utilidad bruta por Servicio:    <h3 id="service_income"> </h3></label></div>
          <div class="col-lg-6"><label>Ganancia por Productos :    <h3 id="product_income"></h3></label></div>
        </div>
        <div class="row">
        <div class="col-lg-6 col-offset-4">
            <label>Total Ingresos : <h3 class="text-success" id="total_income"></h3></label>
        </div>
        </div>
      </div>
    </div>
  </div>
 </div>    
 <div class="row">
 <div class="col-lg-6">
 <div class="card" style="border-radius:15px;border:outset;">
<div class="card-body">
    <h4><label class="text-uppercase">Utilidad operacional: </label>    <b id="total_op"></b></h4>
</div>
 </div>
</div>
</div>
    </div>  
    </div>

<div class="modal fade" id="mdl_createdExpense" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header bg-success d-block">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title text-uppercase text-center" >Concepto de Egreso </h5>
      </div>      
      <div class="modal-body" style="background:white;">
    <hr>
     <meta name="csrf-token" content="{{ csrf_token() }}">                           
    <div class="row">
        <div class="col-lg-6">
        <label for="concepto">Concepto :</label>
                <select class="form-control" id="id_concepto" name="id_concepto" style="width:100%">                    
                </select>    
        </div>        
        <div class="col-lg-6">
        <label for="valor">Valor :</label>
                <input class="form-control" type="number" name="total_egreso" id="total_egreso">
        </div>        
    </div>


    </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
        <button type="submit" id="btn_add_ex" class="btn btn-success">Guardar</button>
      </div>
      
    

    </div>
  </div>

  </div>  
@endsection
@push('style') 
@endpush
@push('custom-scripts')     
<script src="{{ asset('/lib/report.js') }}"></script>    
@endpush

@push('plugin-scripts')
  {!! Html::script('/assets/plugins/chartjs/chart.min.js') !!}


   
@endpush

