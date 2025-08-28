@extends('layout.master')
@push('plugin-styles')
<style>  
  .carousel-inner img {
    width: 100%;
    height: 385px;
  }
  </style>
@endpush
@section('content')
<div class="row">
  <div class="col-md-12 grid-margin">
    <div class="card">
      <div class="card-body">
        <h3>Bienvenido  {{ auth()->user()->name }}</h3>
         <p class="text-muted">Card Wash</p>
      </div>
      </div>
      </div>    
      </div>


<div class="row">
<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">     
      <div class="card-body">                       
      </div>
    </div>
  </div>




</div>
@endsection

@push('plugin-scripts')
  <!-- {!! Html::script('/assets/plugins/chartjs/chart.min.js') !!} -->
@endpush
@push('custom-scripts') 
  <!-- <script src="{{ asset('/lib/report.js') }}"></script>     -->
@endpush