@extends('layout.master')
@section('content')
<div class="row">
<div class="card">
<div class="p-4  bg-light text-center">        
        <h4 class="mb-0">Administraci&oacute;n de Servicios Prestados</h4>        
</div>
    <div class="card-body">    
    <div class="col-lg-12 grid-margin stretch-card">            
        <div class="card">
            <div class="card-body">
            <h4 class="card-title">Cantidad de servicios prestados por Empleados</h4>
             <div class="table-responsive">
                <table id="dt_sales_user" class="table table-hober">
                <thead>
                    <tr>                     
                          <th>Empleado</th>                         
                          <th class="text-center">Servicios<br>Prestados</th>
                          <th class="text-center">Pagos<br>Realizados</th>
                          <th class="text-center bg-warning text-white">Pendientes<br>por Pagar</th>
                          <th class="text-center bg-danger text-white">Monto<br>Pendiente</th>
                          <th class="text-center">Préstamos</th>
                          <th class="text-center">Balance</th>
                      </tr>                
                </thead>                 
            </table>
            </div>
            </div>
        </div>
    </div>
    </div>  
 </div>

<div class="card"> 
       <div class="card-body">
              <div class="row">
              <div class="col-lg-6">
              <label>Fecha ini:</label>
                 <input type="date" class="form-control" id="date_ini">
              </div> 
              <div class="col-lg-6">
                <label>Fecha fin:</label>
                  <input type="date" class="form-control" id="date_end">
                </div>                         
              </div>
              <div class="d-flex justify-content-center pt-4">
                <button type="button" title="" data-toggle="tooltip" class="btn btn-icons btn-rounded btn-success btn_search_income_store" data-original-title="Consultar"><i class="mdi mdi-account-search mdi-18px"></i></button>
              </div> 
              
<br>

            <div class="p-4  bg-light text-center">                
                <h5 class="text-danger">Montos Ingresados al  Establecimiento </p>  <p class="text-muted">Sin Descuento  del pago al trabajador  (*)</h5>     
            </div>
                <div class="col-lg-6">
                <table class="table table-striped text-center">
                  <thead>
                    <tr>
                      <th>Cantidad</th>
                      <th>Servicios Prestados</th>                      
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td class="tbl-tt_prd_qq">0</td>
                      <th>TOTAL :</th>
                      <th class="text-danger tbl-tt_prd">0</th>                      
                    </tr>
                  </tbody>
                  </table>
                </div>

<hr>
                <div class=" p-4  bg-light text-center">
                  <h4 class="text-success">Ganacias del Establecimiento <p class="text-muted ">Aplicando Descuentos</p>    </h4>
                </div>

                      
                <div class="col-lg-6">
                <table class="table table-striped text-center">
                  <thead>
                    <tr>
                      <th colspan="2">Servicios Prestados</th>
                      {{-- <th>Venta de Productos Lubriteca</th> --}}
                    </tr>
                  </thead>
                  <tbody>
                    <tr >
                      <td colspan="2" class="tbl-income-service">$ 0</td>
                      {{-- <td class="tbl-income-prd">$ 0</td> --}}
                    </tr>
                    <tr>
                      <th>TOTAL: </th>
                      <th  class="tbl-income-tt text-success"></th>
                    </tr>
                  </tbody>
                  </table>
                </div>
                  
              </div>
            </div>




              


</div>






<div class="modal fade" id="mdl_paySales" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header bg-success d-block">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title text-uppercase text-center text-white" >Pago por Servicos Realizados   <i class="mdi  mdi-cash-usd text-white"></i></h5>
      </div>      
      <fieldset>
      <div class="modal-body" style="background:white;">        
        <div class="row">
            <input type="hidden" id="id_usuario">
        <div class="table-responsive">
                <table  class="table table-striped dt_pay_pending">
                <thead>
                    <tr>
                        <th> No. venta</th> 
                        <th>Fecha venta</th>
                        <th> Nombre Cliente</th> 
                        <th> Combo</th>
                        <th>Vehiculo</th>
                        <th>Precio Venta</th>
                        <th>Porcentaje %</th>                        
                        <th>Valor </th>
                    </tr>                
                </thead>                 
            </table>
            </div>        
        </div>
    <br>
    <hr>
<!--  <div class="row">

    <div class="col-lg-3">
    <div class="card" style="border-bottom:outset;border-radius:15px;">
                <div class="card-body">
                  <h4 class="card-title"><p class="text-muted text-primary">Ingreso por ventas : </p>  <p class="text-danger">Sin Descuento  del pago al trabajador</p></h4>
                  <label class="text-primary">Total Pago :  <h2 class="payPSales text-success"> </h2>  </label>
              </div>
            </div>
    </div>    
    <div class="col-lg-3">
        <div class="card" style="border-bottom:outset;border-radius:15px;">
            <div class="card-body">
                <h4 class="card-title">
                    <p class="text-muted text-success">Total a pagar con descuentos:</p>
                    <p class="text-success">Se descuenta préstamos pendientes</p>
                </h4>
                <label class="text-primary">Total Neto :
                    <h2 class="payWithDiscount text-success"></h2>
                </label>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="card" style="border-bottom:outset;border-radius:15px;">
            <div class="card-body">
                <h4 class="card-title">
                    <p class="text-muted text-info">Balance General:</p>
                </h4>
                <label class="text-primary">Saldo :
                    <h2 class="employeeBalance text-info"></h2>
                </label>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="card" style="border-bottom:outset;border-radius:15px;">
            <div class="card-body">
                <h4 class="card-title">
                    <p class="text-muted text-success">Se debe realizar el pago del siguiente valor :</p>
                    <p class="text-success">Aplica pago al trabajador (*)</p>
                </h4>
                <label class="text-primary">Total Pago :
                    <h2 class="payPending text-success"></h2>
                </label>
            </div>
        </div>
    </div>
</div>-->


<div class="col-lg-12">
    <table class="table table-bordered table-hover shadow-sm" style="background: #fff; border-radius: 12px;">
        <thead class="thead-light">
            <tr>
                <th colspan="2" class="text-center" style="font-size: 1.2em;">
                    <i class="mdi mdi-cash-multiple"></i> Resumen del Pago al Empleado
                </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <span class="font-weight-bold text-primary">Ingreso por Ventas</span>
                    <br>
                    <small class="text-muted">Total generado por servicios prestados</small>
                </td>
                <td>
                    <span class="h4 payPSales text-success font-weight-bold"></span>
                </td>
            </tr>

             <tr>
                <td>
                    <span class="font-weight-bold text-info">Servicios prestados </span>
                    <br>
                    <small class="text-muted">Total de servicios prestados por empleado</small>
                </td>
                <td>
                    <span class="h4 payPending  text-info font-weight-bold"></span>
                </td>
            </tr>
            <tr>
                <td>
                    <span class="font-weight-bold text-warning">Descuento por Préstamos</span>
                    <br>
                    <small class="text-muted">Total de préstamos pendientes descontados</small>
                </td>
                <td>
                    <span class="h4 loansAll  text-warning font-weight-bold"></span>
                </td>
            </tr>
            <!--<tr>
                <td>
                    <span class="font-weight-bold text-info">Total a Pagar (Neto)</span>
                    <br>
                    <small class="text-muted">Ingreso menos préstamos</small>
                </td>
                <td>
                    <span class="h4  text-info font-weight-bold"></span>
                </td>
            </tr>-->
            <tr>
                <td>
                    <span class="font-weight-bold text-secondary">Balance General</span>
                    <br>
                    <small class="text-muted">Saldo final del empleado después del pago</small>
                </td>
                <td>
                    <span class="h4 employeeBalance text-secondary font-weight-bold"></span>
                </td>
            </tr>
            <tr class="table-success">
                <td>
                    <span class="font-weight-bold text-success">Pago a Realizar</span>
                    <br>
                    <small class="text-muted">Valor final a entregar al trabajador</small>
                </td>
                <td>
                    <span class="h4 payWithDiscount text-success font-weight-bold"></span>
                </td>
            </tr>
        </tbody>
    </table>
</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
        <button type="submit" id="btn_pay_sales" class="btn btn-success">Pagar    <i class="mdi  mdi-cash-usd text-white"></i></button>
      </div>
      </fieldset>          
    </div>
  </div>
</div>   


<div class="modal fade" id="mdl_pay_history" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header bg-info d-block">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title text-uppercase text-center text-white" >Historial de Pagos   <i class="mdi  mdi-cash-usd text-white"></i></h5>
      </div>      
      <fieldset>
      <div class="modal-body" style="background:white;">        
        <div class="row">
            <input type="hidden" id="id_usuario">
        <div class="table-responsive">
                <table id="" class="table table-striped dt_payment_history">
               <thead>
                  <tr>
                      <th>#</th>
                      <th>Fecha de Pago</th>
                      <th>Servicios Pagados</th>
                      <th>Préstamos Descontados</th>
                      <th>Balance Anterior</th>
                      <th>Total Pagado</th>
                      <th>Ticket</th>
                  </tr>
              </thead>                
            </table>
            </div>        
        </div>
    <br>
    <hr>
  <!--<div class="row">
        
    <div class="col-lg-3">
    <div class="card" style="border-bottom:outset;border-radius:15px;">
                <div class="card-body">
                  <h4 class="card-title"><p class="text-muted text-primary">Ingreso por ventas : </p>  <p class="text-danger">Sin Descuento  del pago al trabajador</p></h4>
                  <label class="text-primary">Total Pago :  <h2 class="payPSales text-success"> </h2>  </label>
              </div>
            </div>
    </div>
        <div class="col-lg-6">
        <div class="card" style="border-bottom:outset;border-radius:15px;">
                    <div class="card-body">
                      <h4 class="card-title"><p class="text-muted text-success">Se realizo  el pago del siguiente valor : </p> <p class="text-success">Aplica Pago Al Trabajador (*)</p></h4>
                      <label class="text-primary">Total Pago :  <h2 class="payPending text-success"> </h2>  </label>
                  </div>
                </div>
        </div>
 </div> --> 
  
      
    </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
        <!-- <button type="submit" id="btn_pay_sales" class="btn btn-success">Pagar    <i class="mdi  mdi-cash-usd text-white"></i></button> -->
      </div>
      </fieldset>          
    </div>
  </div>
</div>  

<!-- Modal para detalle de préstamos -->
<div class="modal fade" id="mdl_loans_detail" tabindex="-1" role="dialog" aria-labelledby="mdlLoansDetailLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title">Préstamos Pendientes del Empleado</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- Aquí se cargará el detalle por AJAX -->
      </div>
    </div>
  </div>
</div>


    
@endsection
@push('style') 
@endpush
@push('custom-scripts')     
    <script src="{{ asset('/lib/teacher.js?v=2.0.0') }}"></script>
@endpush
