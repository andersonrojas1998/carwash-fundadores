<!DOCTYPE html>
<html lang="es">
<head>
  <title>C21 CAR WASH</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="_token" content="{{ csrf_token() }}">  

  <!-- Favicon -->
  <link rel="shortcut icon" href="{{ asset('/icon.jpg') }}">

  <!-- Preconnect a CDN externo -->
  <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>

  <!-- Preload de CSS crítico -->
  <link rel="preload" href="{{ mix('css/app.css') }}" as="style">

  <!-- Plugin CSS -->
  {!! Html::style('assets/plugins/@mdi/font/css/materialdesignicons.min.css') !!}
  {!! Html::style('assets/plugins/perfect-scrollbar/perfect-scrollbar.css') !!}

  <!-- CSS común -->
  {!! Html::style(mix('css/app.css')) !!}
  {!! Html::style('css/select2.min.css') !!}
  {!! Html::style('css/datatable/datatable.bootstrap4.min.css') !!}
  {!! Html::style('css/datatable/buttons.datatable.min.css') !!}

  @stack('plugin-styles')
  @stack('style')
</head>
<body data-base-url="{{ url('/') }}">

  <div class="container-scroller" id="app">
    @include('layout.header')
    <div class="container-fluid page-body-wrapper">
      @include('layout.sidebar')
      <div class="main-panel">
        <div class="content-wrapper">       
          @yield('content')               
        </div>
        @include('layout.footer')
      </div>
    </div>
  </div>

  <!-- Base JS (con defer para no bloquear render) -->
  {!! Html::script(mix('js/app.js')) !!}
  {!! Html::script('assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js') !!}
  {!! Html::script('js/datatable/jquery.datatable.min.js') !!}
  {!! Html::script('js/datatable/bootstrap.buttons.min.js') !!}
  {!! Html::script('js/datatable/bootstrap.buttons.display.min.js') !!}
  {!! Html::script('js/datatable/select2.min.js') !!}

  <!-- SweetAlert desde CDN -->
  {!! Html::script('https://cdn.jsdelivr.net/npm/sweetalert2@10') !!}

  <!-- Global JS -->
  {!! Html::script('lib/global.js?v=1') !!}
  {!! Html::script('assets/js/settings.all.min.js') !!}

  @stack('plugin-scripts')
  @stack('custom-scripts')

</body>
</html>
