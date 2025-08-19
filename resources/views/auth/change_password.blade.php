@extends('layout.master')
@section('content')
<div class="card mt-5 mx-auto" style="max-width:400px;">
    <div class="card-header"><h4>Cambiar Contraseña</h4></div>
    <div class="card-body">
        <form method="POST" action="{{ route('password.update') }}">
            <div class="form-group">
                <label for="current_password">Contraseña Actual</label>
                <input type="password" name="current_password" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="new_password">Nueva Contraseña</label>
                <input type="password" name="new_password" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="new_password_confirmation">Confirmar Nueva Contraseña</label>
                <input type="password" name="new_password_confirmation" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Actualizar</button>
        </form>
    </div>
</div>
@endsection