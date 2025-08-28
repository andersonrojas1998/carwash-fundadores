@extends('layout.master')
@section('content')
<div class="card">
    <div class="card-header"><h1>Editar Servicio</h1></div>
    <form id="form_edit_service" action="{{route('servicio.update', [$servicio->id])}}" method="POST">
        {{ csrf_field() }}
        {{ method_field('PUT') }}
        <fieldset>
            <div class="card-body">
                <div class="d-flex justify-content-around mb-3">
                    <div class="col-lg-4">
                        <label for="input_name_service">Nombre o descripci&oacute;n&nbsp;:</label>
                        <input type="text" id="input_name_service" name="nombre" class="form-control text-uppercase" placeholder="Ingrese el nombre del servicio" value="{{$servicio->nombre}}" required>
                        @if ($errors->any() && $errors->first('nombre'))
                            <span class="badge badge-pill badge-danger">{{$errors->first('nombre')}}</span>
                        @endif
                    </div>

                    <div class="col-lg-4">
                        <label for="input_sell_price">Precio de venta&nbsp;:</label>
                        <input type="number" id="input_sell_price" name="precio_venta" class="form-control text-uppercase" placeholder="Ingrese el precio de venta del servicio" value="@if($servicio->servicio_tipo_vehiculo != null){{$servicio->servicio_tipo_vehiculo->precio_venta}}@endif" required>
                        @if ($errors->any() && $errors->first('precio_venta'))
                            <span class="badge badge-pill badge-danger">{{$errors->first('precio_venta')}}</span>
                        @endif
                    </div>

                    
                </div>

                <div class="d-flex justify-content-center mb-3">
                    <div class="col-lg-4">
                        <label for="input_worker_percentage" class="control-label">Porcentaje trabajador&nbsp;:</label>
                        <input type="text" id="input_worker_percentage" name="porcentaje_trabajador" class="form-control text-uppercase" placeholder="Ingrese el porcentaje para el trabajador" value="@if($servicio->servicio_tipo_vehiculo != null) {{$servicio->servicio_tipo_vehiculo->porcentaje_trabajador}} @endif" required>
                        @if ($errors->any() && $errors->first('porcentaje_trabajador'))
                            <span class="badge badge-pill badge-danger">{{$errors->first('porcentaje_trabajador')}}</span>
                        @endif
                    </div>
                </div>

                <div class="card">
                    <div class="card-header text-center">
                        Seleccione el tipo de vehiculo al que aplica el servicio
                    </div>
                    <div>
                        <div class="d-flex justify-content-center pt-4">
                            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                @foreach($tipos_vehiculo as $tipo_vehiculo)
                                <label class="btn btn-outline-primary">
                                    <input type="radio" name="id_tipo_vehiculo" value="{{$tipo_vehiculo->id}}" @if($servicio->servicio_tipo_vehiculo != null && $tipo_vehiculo->id == $servicio->servicio_tipo_vehiculo->tipo_vehiculo->id) checked @endif> 
                                    <img src="{{asset($tipo_vehiculo->imagen_url)}}" class="rounded" alt="{{$tipo_vehiculo->descripcion}}" data-toggle="tooltip" title="{{$tipo_vehiculo->descripcion}}" height="90px" width="140px">
                                </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="d-flex justify-content-end">
                    <button type="submit" id="btn_create_service" class="btn btn-success">Guardar</button>
                </div>
            </div>
        </fieldset>
    </form>
</div>
@endsection
@push('custom-scripts')
    {!! Html::script('js/validate.min.js') !!}
    {!! Html::script('js/validator.messages.js') !!}
    {!! Html::script('lib/service.js') !!}
@endpush