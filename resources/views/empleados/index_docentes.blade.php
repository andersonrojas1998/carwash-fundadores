@extends('layout.master')
@section('content')
<div class="card">
<div class="p-4  bg-light text-center">        
        <h4 class="mb-0">Administraci&oacute;n de Usuarios</h4>        
</div>
    <div class="card-body">    
    <div class="d-flex flex-row-reverse bd-highlight mb-5">
            <div class="p-2 bd-highlight">
                <a href="/usuarios/creacion" data-toggle="tooltip" data-placement="top" data-title="Creacion de Personal" class="btn btn-primary" >Creaci&oacute;n <i class="mdi mdi-account-circle icon-lg" ></i> </a>
            </div>            
        </div>
    <div class="table-responsive">
                <table id="dt_teacher" class="table table-bordered table-hover" style="width:100%;" >
                    <thead>
                    <tr class="bg-secondary">
                        <th>#</th>
                        <th>Identificacion</th>
                        <th>Nombre</th>                    
                        <th>Celular</th>                        
                        <th>Genero</th>
                        <th>Cargos</th>   
                        <th>Estado</th> 
                        <th></th>                
                    </tr>
                    </thead>
                    <tbody>                            
                    </tbody>
                     <tfoot>
                    <tr>
                        <td><i class="mdi mdi-account-check"></i></td>
                        <td><i class="mdi mdi-account-key"></i></td>
                        <td><i class="mdi mdi-account-check"></i></td>
                        <td><i class="mdi mdi-cellphone-iphone"></i></td>
                        <td><i class="mdi mdi-gender-female"></i></td>                        
                        <td><i class="mdi mdi-account-check"></i></td>
                        <td><i class="mdi mdi-account-check"></i></td>
                        <td><i class="mdi mdi-account-check"></i></td>
                    </tr>
                    </tfoot>
                    </table>  
    </div>
    </div>  
    </div>

<div class="modal fade" id="mdl_editUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header bg-warning d-block">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title text-uppercase text-center" >Editar usuario   <i class="mdi mdi-account-card-details"></i></h5>
      </div>
      <form  id="form_updateUser" enctype="multipart/form-data" method="post">
      <fieldset>
      <div class="modal-body" style="background:white;">


      
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <div class="row">
            <input type="hidden" id="id_user">
        <div class="col-lg-4">
            <label>Identificaci&oacute;n :</label>
            <input type="text" id="identificacion" nama="identificacion" disabled class="form-control">
        </div>                        

        <div class="col-lg-4">
            <label>Nombre :</label>
            <input type="text" id="nombre" name="nombre" class="form-control text-uppercase" required>
        </div>


        <div class="col-lg-4">
            <label>Email : </label>
            <input type="text"  id="email" name="email" placeholder="Ingrese email" class="form-control">
        </div>
        </div>
<br>
    <div class="row">
    <div class="col-lg-4">
        <label>Celular  </label>
            <input type="number" id="celular" name="celular" placeholder="Ingrese celular" class="form-control">
        </div>
        <div class="col-lg-4">
        <label>Telefono : </label>
            <input type="number"  id="telefono" name="telefono" placeholder="Ingrese telefono" class="form-control">
        </div>

        <div class="col-lg-4">
        <label>Direcci&oacute;n  :</label>
            <input type="text" id="direccion" name="direccion" placeholder="Ingrese direccion"  class="form-control">
        </div>
    </div>
<br>
    <div class="row">
    
    <div class="col-lg-4">
        <label>Fecha nacimiento: </label>
            <input type="date"  id="nacimiento" name="nacimiento" placeholder="Ingrese fecha de nacimiento" class="form-control">
        </div>

        <div class="col-lg-4">
        <label>Lugar expedición:</label>
            <input type="text" id="expedicion" name="expedicion" placeholder="Ingrese lugar de expedicion" class="form-control">
        </div>
    
        <div class="col-lg-4">
        <label>Genero:</label>
            <select class="form-control select2" id="genero"  name="genero" style="width:100%">
            <option value="M">Masculino</option>
            <option value="F">Femenino</option>
            </select>
        </div>        
    </div>
    <hr>
    <div class="row">
        <div class="col-lg-4">
        <label for="estado">Estado :</label>
                <select class="form-control select2" id="estado" name="estado" style="width:100%">
                    <option value="1">Activo</option>
                    <option value="0">Inactivo</option>
                </select>    
        </div>        
    </div>

  
    </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
        <button type="submit" id="btn_update_users" class="btn btn-success">Guardar</button>
      </div>
      </fieldset>
    </form>

    </div>
  </div>
</div>    
@endsection
@push('style') 
@endpush
@push('custom-scripts') 
    <script src="{{ asset('/js/validate.min.js')}}"></script>
    <script src="{{ asset('/js/validator.messages.js')}}"></script>   
    <script src="{{ asset('/lib/teacher.js?v=1.0.0') }}"></script>
@endpush
