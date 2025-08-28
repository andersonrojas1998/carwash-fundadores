@foreach ($tipos_producto as $tipo_producto)
    <option value="{{ $tipo_producto->id }}">{{ $tipo_producto->descripcion }}</option>
@endforeach