@foreach ($marcas as $marca)
    <option value="{{ $marca->id }}">{{ $marca->nombre }}</option>
@endforeach