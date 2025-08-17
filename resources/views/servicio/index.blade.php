@extends('layout.master')
@section('content')
<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between bd-highlight mb-3">
            <div class="d-flex justify-content-start bd-highlight">
                <div class="p-4 bg-light">
                    <h4>SERVICIOS</h4>
                </div>
            </div>
            <div class="d-flex justify-content-end bd-highlight">
                <div class="pr-3 pt-3" title="Crear servicio" data-toggle="tooltip">
                    <a href="{{route('servicio.create')}}" class="text-body">
                        <span class="mdi mdi-plus-circle-outline mdi-36px"></span>
                    </a>
                </div>
            </div>
        </div>
        @php
            $i = 1;
            $bg_colors = ['bg-primary', 'bg-danger', 'bg-warning', 'bg-info', 'bg-success', 'bg-light'];
            $text_colors = ['text-light', 'text-light', 'text-dark', 'text-light', 'text-dark', 'text-dark'];
            $index_colors = array_rand($bg_colors);
        @endphp
          @foreach($servicios as $key => $servicio)
            @if($i == 1)
            <div class="card-deck my-2">
            @endif
            <div class="card card-service border-dark text-center text-light">
                <div class="card-header bg-dark px-2">
                    <h4><strong>{{$servicio->nombre}}</strong></h4>
                </div>
              <div class="card-body {{$bg_colors[$index_colors]}} px-2 py-3">
                <strong class="{{$text_colors[$index_colors]}}">{{$servicio->servicio_tipo_vehiculo->tipo_vehiculo->descripcion}}</strong>
                <strong class="{{$text_colors[$index_colors]}}">$ {{$servicio->servicio_tipo_vehiculo->precio_venta}}</strong>
                    <hr>
                    <strong class="{{$text_colors[$index_colors]}}">Camioneta</strong>
                    <strong class="{{$text_colors[$index_colors]}}">$45.000</strong>
              </div>
              <div class="card-footer {{$bg_colors[$index_colors]}}">
                <strong class="card-title {{$text_colors[$index_colors]}}">Lavada - Aspirada <br> Brillada - Silicona <br> Llantil</strong>
              </div>
            </div>
            @php
              $index_colors = array_rand($bg_colors);
            @endphp
            @if($i == 4 || !isset($servicios[$key+1]))
            </div> @php $i = 1; continue; @endphp
            @endif
            @php $i++; @endphp
          @endforeach
        <div class="table-responsive">
            <table class="table table-striped table-sm" id="table-service" data-url="{{route('servicio.data')}}">
                <thead>
                    <tr>
                        <th>Nombre (Referencia)</th>
                        <th>Tipo vehiculo</th>
                        <th>Precio</th>
                        <th>Acci&oacute;n</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($servicios as $servicio)

                    <tr>
                        <td>{{$servicio->nombre}}</td>
                        <td>{{$servicio->servicio_tipo_vehiculo->tipo_vehiculo->descripcion}}</td>
                        <td>$ {{$servicio->servicio_tipo_vehiculo->precio_venta}}</td>
                        <td>
                            <a href="{{route('servicio.edit',[$servicio->id])}}" title="Editar servicio" data-toggle="tooltip">
                                <i class="mdi mdi-pencil-box-outline text-primary mdi-24px"></i>
                            </a>
                        </td>
                    </tr>

                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @if(session('success'))
        <input type="hidden" id="succes_message" value="{{session('success')}}">
    @endif

    @if(session('fail'))
        <input type="hidden" id="fail_message" value="{{session('fail')}}">
    @endif
</div>
@endsection
@push('custom-scripts')
    {!! Html::script('js/validate.min.js') !!}
    {!! Html::script('js/validator.messages.js') !!}
    {!! Html::script('lib/service.js') !!}
@endpush