@extends('layout.master')
@section('content')
<div class="card">
    <div class="card-header bg-light">                           
                <h4 class="pt-2">PRESTAMOS Y VALES &nbsp;  <i class="mdi mdi-cash-multiple"></i></h4>
                <button class="btn btn-success float-right" data-toggle="modal" data-target="#mdl_loans">Registrar prestamo  &nbsp; <i class="mdi mdi-cash-multiple"></i></button>                
        </div>
    <div class="card-body">
        
        <div class="table-responsive">
            
        <table class="table DataTable">
            <thead>
                <tr>                   
                    <th>Socio</th>
                    <th>Valor</th>
                    <th>Concepto</th>
                    <th>Fecha Prestamo</th>
                    <th>Fecha Pago</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($loans as $loan)
                    <tr>                    
                        <td>{{ $loan->user->name }}</td>                        
                        <th class="text-danger">$ {{ number_format($loan->valor,0,',','.')}}</th>
                        <td>{{ $loan->concepto }}</td>
                        <td>{{ $loan->fecha_prestamo }}</td>
                        <td>{{ $loan->fecha_pago }}</td>                                          
<td>
    <button type="button" class="btn btn-warning btn-edit-loan" data-id="{{ $loan->id }}">
        <i class="mdi mdi-pencil"></i> Editar
    </button>
    <button type="button" class="btn btn-danger btn-delete-loan" data-id="{{ $loan->id }}">
        <i class="mdi mdi-delete"></i> Eliminar
    </button>
</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        </div>
    </div>
</div>



<!-- Modal para registrar/editar prestamos -->
<div class="modal fade" id="mdl_loans" tabindex="-1" role="dialog" aria-labelledby="mdlLoansLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form id="form_loans" method="POST">
         {{ csrf_field() }}
         <meta name="csrf-token" content="{{ csrf_token() }}">
         <input type="hidden" id="loan_id" name="loan_id">
      <div class="modal-content">
        <div class="modal-header bg-info">
          <h5 class="modal-title text-white" id="modalTitle">Registrar Préstamo &nbsp; <i class="mdi mdi-cash-multiple"></i></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label for="id_usuario">Trabajador</label>
                <select id="id_usuario" name="id_usuario" class="form-control select2" required style="width:100%">
                    @foreach($empleados as $empleado)
                        <option value="{{ $empleado->id }}">{{ $empleado->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="valor">Valor</label>
                <input type="number" id="valor" name="valor" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="concepto">Concepto</label>
                <input type="text" id="concepto" name="concepto" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="fecha_prestamo">Fecha Préstamo</label>
                <input type="date" id="fecha_prestamo" name="fecha_prestamo" class="form-control" required>
            </div>         
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-success" id="btnSaveLoan">Registrar</button>
        </div>
      </div>
    </form>
  </div>
</div>
@endsection
@push('custom-scripts')
    {!! Html::script('lib/loans.js') !!}
@endpush