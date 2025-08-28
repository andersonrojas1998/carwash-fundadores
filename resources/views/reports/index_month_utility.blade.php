@extends('layout.master')
@section('content')
<div class="card">
<div class="p-4  bg-light text-center">        
        <h4 class="mb-0">Indicadores de utilidad por meses</h4>        
</div>
    <div class="card-body">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="p-4 border-bottom bg-light">
                <h4 class="card-title mb-0">Utilidades para el año {{ date('Y')}} </h4>
            </div>
            <div class="card-body">
                <div class="chartjs-size-monitor">
                    <div class="chartjs-size-monitor-expand">
                        <div class=""></div>
                    </div>
                    <div class="chartjs-size-monitor-shrink">
                        <div class=""></div>
                    </div>
                </div>                
                <canvas id="char_utility_month" style="height: 225px; display: block; width: 451px;" width="451" height="225" class="chartjs-render-monitor"></canvas>
            </div>
        </div>
    </div>  
</div>
</div>
@endsection
@push('style') 
@endpush

@push('plugin-scripts')
<script src="{{ asset('/lib/report.js') }}"></script>    
  {!! Html::script('/assets/plugins/chartjs/chart.min.js') !!}

 
@endpush

