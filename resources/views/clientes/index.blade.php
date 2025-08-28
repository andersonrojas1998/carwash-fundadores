@extends('layout.master')
@section('content')
<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between bd-highlight mb-3">
            <div class="d-flex justify-content-start bd-highlight">
                <div class="p-4 bg-light">
                    <h4>LISTADO DE CLIENTES</h4>
                </div>
            </div>
            <div class="d-flex justify-content-end bd-highlight">               
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-sm" id="clientes-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Telefono</th>
                        <th>Placa</th>  
                        <th>Tipo Vehiculo</th>
                        <th>Cantidad Servicios</th>                      
                    </tr>
                </thead>                
            </table>
        </div>
    </div>
</div>




@endsection
@push('custom-scripts')
    {!! Html::script('lib/customer.js') !!}
@endpush