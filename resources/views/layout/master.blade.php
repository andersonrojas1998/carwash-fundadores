<!DOCTYPE html>
<html>
<head>
  <title>C21 CAR WASH</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <!-- CSRF Token -->
  <meta name="_token" content="{{ csrf_token() }}">
  
  <link rel="shortcut icon" href="{{ asset('/icon.jpg') }}">

  <!-- plugin css -->
  {!! Html::style('assets/plugins/@mdi/font/css/materialdesignicons.min.css') !!}
  {!! Html::style('assets/plugins/perfect-scrollbar/perfect-scrollbar.css') !!}
  <!-- end plugin css -->

      
  @stack('plugin-styles')

  <!-- common css -->
  {!! Html::style('css/app.css') !!}
  <!-- end common css -->    
      {!! Html::style('https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css') !!}
      
      
      {!! Html::style('css/datatable/datatable.bootstrap4.min.css') !!}
      {!! Html::style('css/datatable/buttons.datatable.min.css') !!}      



      
  @stack('style')
</head>
<body data-base-url="{{url('/')}}">

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

  <!-- base js -->
  {!! Html::script('js/app.js') !!}
  {!! Html::script('assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js') !!}


  {!! Html::script('js/datatable/jquery.datatable.min.js') !!}
  {!! Html::script('js/datatable/bootstrap.datatable.min.js') !!}    


  {!! Html::script('https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js') !!}    
    {!! Html::script('https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js') !!}    
      {!! Html::script('https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js') !!}    

  {!! Html::script('js/datatable/datatable.buttons.min.js') !!}
  {!! Html::script('js/datatable/buttons.html5.min.js') !!}            
  {!! Html::script('js/datatable/buttons.print.min.js') !!}

  {!! Html::script('https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js') !!}      
  
                    

  {!! Html::script('//cdn.jsdelivr.net/npm/sweetalert2@10') !!}  
  {!! Html::script('lib/global.js?v.1') !!}
  <!-- end base js -->


  {!! Html::script('assets/js/off-canvas.js') !!}
  {!! Html::script('assets/js/hoverable-collapse.js') !!}
  {!! Html::script('assets/js/misc.js') !!}
  {!! Html::script('assets/js/settings.js') !!}
  {!! Html::script('assets/js/todolist.js') !!}

  <!-- plugin js -->
  @stack('plugin-scripts')
  <!-- end plugin js -->

  <!-- common js -->

  <!-- end common js -->

  @stack('custom-scripts')

</body>
</html>