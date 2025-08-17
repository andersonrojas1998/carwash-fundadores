@extends('layout.master')
@section('content')
<div class="row">

    <div class="col-lg-12  grid-margin stretch-card">
        <div class="card">
    
        <div class="pt-3  bg-light">
            <h4 class="mb-0 text-center   font-weight-medium ">Calificaciones por grado  <i class="menu-icon mdi mdi-television "></i></h4>
        </div>
        <hr>
              
        
        <div class="card-body">

        <div class="row pt-5">
        <div class="col-lg-4 grid-margin stretch-card">
                <strong class="col-lg-5">Grados :</strong>
                <select class="form-control" id="sel_gradeScore" style="width:100%;">        
                </select>                                                                                     
                </div>


                <div class="col-lg-4 grid-margin stretch-card">
                <strong class="col-lg-5">Periodo :</strong>
                <select class="form-control select2" id="sel_periodScore" style="width:100%;">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                </select>                                                                                     
                </div>

                <div class="col-lg-2">
                    <button type="button" class="btn btn-icons btn-rounded btn-success" data-toggle="tooltip" data-placement="top" data-title="Consultar" id="btn_showChartApproved"><i class="mdi mdi-account-search" style="font-size:20px;"></i></button>                
                </div>                
        </div>

        
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                <div class="p-4 border-bottom bg-light">
                    <h4 class="card-title mb-0">Resumen</h4>
                </div>
                <div class="card-body">
                    <div class="d-sm-flex justify-content-between align-items-center pb-4">
                    <h4 class="card-title mb-0">Cantidad de estudiantes que aprobaron las asignaturas</h4>
                    <div id="stacked-bar-traffic-legend"></div>
                    </div>                    
                    <canvas id="barChart" style="height:250px"></canvas>
                </div>
                </div>
            </div>                    
            </div>
        </div>
    </div>
</div>
@endsection
@push('plugin-scripts')

<script src="{{ asset('/lib/scoreStudent.js') }}"></script>    
    <script src="{{ asset('/lib/report.js') }}"></script>    
  {!! Html::script('/assets/plugins/chartjs/chart.min.js') !!}


@endpush
