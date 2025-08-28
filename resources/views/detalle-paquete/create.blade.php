@extends('layout.master')
@section('content')
<div class="card">
    <div class="card-header"><h1>Crear Combo o Servicio</h1></div>
    <form id="form_create_service" action="{{route('detalle-paquete.store')}}" method="POST">
        {{ csrf_field() }}
        <fieldset>
            <div class="card-body">
                @if($errors->any() && $errors->first('id_paquete'))
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>¡Advertencia!</strong> {{$errors->first('id_paquete')}}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                @if($errors->any() && $errors->first('precio_venta'))
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>¡Advertencia!</strong> {{$errors->first('precio_venta')}}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                @if($errors->any() && $errors->first('id_tipo_vehiculo'))
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>¡Advertencia!</strong> {{$errors->first('id_tipo_vehiculo')}}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                @if($errors->any() && $errors->first('porcentaje'))
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>¡Advertencia!</strong> {{$errors->first('porcentaje')}}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                <div class="d-flex justify-content-around mb-3">
                    <div class="col-lg-4">
                        <label class="control-label" >Combos:</label>
                        <div class="input-group">
                            <select class="select2 disabled-elements" id="select-package" name="id_paquete" disabled style="width: 80%">
                                <option value="">Seleccione...</option>
                                @if(count($paquetes_sin_parametrizar) != 0)
                                    @foreach($paquetes_sin_parametrizar as $paquete)
                                        <option value="{{$paquete->id}}" data-url="{{route('detalle-paquete.unrelatedVehicleType',[$paquete->id])}}">{{$paquete->nombre}}</option>
                                    @endforeach
                                @else
                                <option value="">No existen combos por parametrizar</option>
                                @endif
                            </select>
                            <div class="input-group-append" title="Agregar combo" data-toggle="tooltip">
                                <button class="btn btn-outline-secondary disabled-elements" type="button" data-toggle="modal" data-target="#modal_create_package" disabled>
                                    <span class="mdi mdi-plus-circle-outline mdi-24px"></span>
                                </button>
                            </div>
                        </div>
                        @if (old('id_paquete'))
                            <input type="hidden" id="old-select-package" value="{{ old('id_paquete') }}">
                        @endif
                    </div>
                </div>

                <div class="card mb-5 d-none" id="div_vehicle_type">
                    <div class="card-header text-center">
                        Seleccione el tipo de vehiculo al que aplica el servicio
                    </div>
                    <div class="d-flex justify-content-center pt-4">
                        <div class="btn-group-toggle" data-toggle="buttons" id="buttons-vehicle-type"></div>
                    </div>
                </div>
                <div id="div_services" class="d-none">
                    <div class="card border border-danger">
                        <div class="card-header text-center">
                            Agregar servicios
                        </div>
                        <div class="card-body">
                            <div class="container">
                                <ul class="nav nav-tabs" id="nav-add-services"></ul>

                                <div class="tab-content" id="tab-add-services"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="d-flex justify-content-end">
                    <button type="submit" id="btn_create_service" class="btn btn-success disabled-elements" disabled>Guardar</button>
                </div>
            </div>
        </fieldset>
    </form>
</div>
<div class="d-none" id="options-for-services">
    @foreach($servicios as $servicio)
        <option value="{{$servicio->id}}">{{$servicio->nombre}}</option>
    @endforeach
</div>
@include('paquete.create')
@endsection
@push('custom-scripts')
    {!! Html::script('js/validate.min.js') !!}
    {!! Html::script('js/validator.messages.js') !!}
    {!! Html::script('lib/package.js') !!}
@endpush