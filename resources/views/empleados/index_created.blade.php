@extends('layout.master')
@section('content')
<div class="card">
<div class="p-4">        
        <h3 class="mb-1">Creaci&oacute;n de usuarios  <i class="mdi mdi-account-circle"></i></h3>      
</div>
    <div class="card-body"> 
<h4 class="text-center p-1 text-primary">Datos Basicos  <i class="mdi mdi-account-card-details"></i></h4>
<hr>
<form  id="form_createUser" enctype="multipart/form-data" method="post">
<fieldset>
<meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="row">
        
    <div class="col-lg-4 ">
        <strong>Identificaci&oacute;n :  <span class="text-danger">*</span></strong>
            <input class="form-control" name="identificacion" type="number" >
        <p class="text-muted">Por favor ingrese identificacion</p>            
        </div>

    <div class="col-lg-4">
        <strong>Nombre : <span class="text-danger">*</span></strong>
            <input class="form-control text-uppercase" name="name" type="text" required>
            <p class="text-muted">Por favor ingrese nombre completo</p>            
        </div>


        <div class="col-lg-4">
        <strong >Email : </strong>
            <input class="form-control" type="email" name="email" placeholder="administrador@inmode.edu.co">
            <p class="text-muted">Por favor ingrese email</p>
        </div>
      </div>
        <br>

       <div class="row">
       <div class="col-lg-4">
        <label for="celular" >Celular: </strong>
            <input class="form-control" name="celular" type="number" >
            <p class="text-muted">Por favor ingrese celular de contacto</p>
        </div>

        <div class="col-lg-4">
        <strong>Telefono : </strong>
            <input class="form-control" name="telefono" type="number">
        </div>
        <div class="col-lg-4">
        <strong>Direcci&oacute;n : </strong>
            <input class="form-control" name="direccion" type="text">
        </div>                              
      </div>
      <br>
      <div class="row">
      <div class="col-lg-4 ">
        <strong>Fecha nacimiento: </strong>
            <input class="form-control" name="nacimiento" type="date">
        </div>      

        <div class="col-lg-4 ">
        <strong>Lugar expedici&oacute;n: </strong>
            <input class="form-control" type="text" name="expedicion">
        </div>      
        <div class="col-lg-4 ">
        <strong>Genero: </strong>
            <select class="form-control select2" name="genero">
                <option></option>
                <option value="M">Masculino</option>
                <option value="F">Femenino</option>
            </select>
        </div>
      </div>
        <hr>
        <h4 class="text-center p-3 text-primary">Datos Administrativos  <i class="mdi mdi-account-box"></i></h4>


        <div class="row">                    

        <div class="col-lg-4">
        <strong>Cargo :  <span class="text-danger">*</span></strong>
        <select class="form-control select2" name="cargo" required>
                <option></option>
                @foreach($roles as $value)
                <option value="{{$value->id}}">{{$value->name }}</option>
                @endforeach                
            </select>
            <p class="text-muted">Por favor seleccione el cargo</p>
        </div>

        <div class="col-lg-4">
            <strong>Contraseña: <span class="text-danger">*</span></strong>
            <input class="form-control" name="password" type="password" required>
            <p class="text-muted">Por favor ingrese la contraseña</p>
        </div>
      </div>
      <hr>
<br>
     <div class="row">
     <div class="col-lg-4 offset-4">
            <button type="submit" class="btn btn-success btn-block" id="submit_users" data-toggle="tooltip" data-placement="top" data-title="Creacion de usuarios">Registrar  <i class="mdi mdi-content-save"></i></button>
     </div>
     </div>

     </fieldset>
    </form>
    </div>
    </div>
@endsection
@push('custom-scripts')    
    <script src="{{ asset('/js/validate.min.js')}}"></script>
    <script src="{{ asset('/js/validator.messages.js')}}"></script>
    <script src="{{ asset('/lib/teacher.js?v=2.0.0') }}"></script>    
@endpush
@push('style')    
<style>
label.error {
    color: red;
    font-size: 1rem;
    display: block;
    margin-top: 5px;
}
input.error {
    border: 1px dashed red;
    font-weight: 300;
    color: red;
}
</style>
@endpush