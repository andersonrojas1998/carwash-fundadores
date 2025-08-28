@extends('layout.master')
@section('content')
<div class="card">
    <div class="card-header"><h1>Editar Combo o Servicio</h1></div>
    <form id="form_create_service" action="{{route('detalle-paquete.update', [$detalle_paquete->id])}}" method="POST">
        {{ csrf_field() }}
        {{ method_field('PUT') }}
        <fieldset>
            <div class="card-body">
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
                        <label class="control-label" >Combo:</label>
                        <input class="form-control rounded" type="text" readonly value="{{$detalle_paquete->paquete->nombre}}">
                        <input type="hidden" name="id_paquete" value="{{$detalle_paquete->paquete->id}}">
                    </div>
                </div>

                <div class="card mb-5">
                    <div class="card-header text-center">
                        Tipo de vehiculo
                    </div>
                    <div class="d-flex justify-content-center pt-4">
                        <div class="btn-group-toggle" data-toggle="buttons">
                            <label class="btn btn-outline-primary">
                                <input type="radio" name="id_tipo_vehiculo" value="{{$detalle_paquete->tipo_vehiculo->id}}" checked>
                                <img src="{{asset($detalle_paquete->tipo_vehiculo->imagen)}}" class="rounded" alt="{{$detalle_paquete->tipo_vehiculo->descripcion}}" title="{{$detalle_paquete->tipo_vehiculo->descripcion}}" data-toggle="tooltip" style="height: 90px; width: 140px;">
                            </label>
                        </div>
                    </div>
                </div>
                <div class="card border border-danger">
                    <div class="card-header text-center">
                        Editar servicios
                    </div>
                    <div class="card-body">
                        <div class="container">
                            <ul class="nav nav-tabs" id="nav-add-services">
                                <li class="nav-item" id="nav-services-{{strtolower($detalle_paquete->tipo_vehiculo->descripcion)}}"><a class="nav-link active" href="#tab-services-{{strtolower($detalle_paquete->tipo_vehiculo->descripcion)}}" data-toggle="tab">{{$detalle_paquete->tipo_vehiculo->descripcion}}</a></li>
                            </ul>

                            <div class="tab-content" id="tab-add-services">
                                <div class="tab-pane container active" id="tab-services-{{strtolower($detalle_paquete->tipo_vehiculo->descripcion)}}">
                                    <div class="d-flex justify-content-around mt-3">
                                        <div class="col-lg-4">
                                            <label>Precio de venta</label>
                                            <input type="number" class="form-control" name="precio_venta" value="{{$detalle_paquete->precio_venta}}">
                                        </div>
                                        <div class="col-lg-4">
                                            <label>Porcentaje trabajador</label>
                                            <input type="number" class="form-control" name="porcentaje" value="{{$detalle_paquete->porcentaje}}">
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-center mt-3">
                                        <div class="col-lg-6">
                                            <label>Servicios</label>
                                            <select class="select2" id="select_service" style="width: 100%">
                                                @foreach($servicios as $servicio)
                                                    @if($detalle_paquete->servicio_paquete->where('id_servicio', $servicio->id)->count() == 0)
                                                        <option value="{{$servicio->id}}">{{$servicio->nombre}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-lg-2">
                                            <div class="row text-light">*</div>
                                            <div class="d-flex justify-content-end pt-2">
                                                <button type="button" id="button-add-services" class="btn btn-success button-add-services" data-key="3">Agregar</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-4">
                                        <div class="table-responsive">
                                            <table id="table-services" class="table table-striped text-center"><thead><tr><th>Nombre</th><th>Acci&oacute;n</th></tr></thead>
                                                <tbody>
                                                    @foreach($detalle_paquete->servicio_paquete as $servicio_paquete)
                                                        <tr>
                                                            <td>{{$servicio_paquete->servicio->nombre}}<input type="hidden" value="{{$servicio_paquete->servicio->id}}" name="id_servicio[]"></td>
                                                            <td>
                                                                <a class="btn-remove-service" data-text="{{$servicio_paquete->servicio->nombre}}" data-id="{{$servicio_paquete->servicio->id}}" data-id-package-service="{{$servicio_paquete->id}}"><i class="mdi mdi-minus-box text-danger mdi-24px"></i></a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div id="removed-services"></div>
                                </div>
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
    
</div>
@include('paquete.create')
@endsection
@push('custom-scripts')
    {!! Html::script('js/validate.min.js') !!}
    {!! Html::script('js/validator.messages.js') !!}
    {!! Html::script('lib/package.js') !!}
@endpush