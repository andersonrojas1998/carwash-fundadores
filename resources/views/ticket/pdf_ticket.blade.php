<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <style type="text/css">
            * {
    font-size: 12px;
    font-family: 'Times New Roman';
}

td,
th,
tr,
table {
    border-top: 1px solid black;
    border-collapse: collapse;
}

td.description,
th.description {
    width: 75px;
    max-width: 75px;
}

td.quantity,
th.quantity {
    width: 40px;
    max-width: 40px;
    word-break: break-all;
}

td.price,
th.price {
    width: 40px;
    max-width: 40px;
    word-break: break-all;
}

.centered {
    text-align: center;
    align-content: center;
}

.ticket {
    width: 155px;
    max-width: 155px;
}

img {
    max-width: inherit;
    width: inherit;
}

@media print {
    .hidden-print,
    .hidden-print * {
        display: none !important;
    }
}
            
        </style>
        <title>Ticket-{{ $venta->id}}  </title>
    </head>
    <body>
        <div class="ticket">
            <br>
           <img class="centered"  src="{{ asset('/icon.jpg') }}" height="80" width="80"> 
            <br><br>
            <p class="centered">
            <b class="w3-jumbo ">C21 </b> <br>
            Lavado y Mantenimiento de Vehiculos Automotores <br>
            JORGE ANDRES DIAZ CRUZ <br>          
            Nit: 1.144.189.073-3 <br>            
            No Responsable del IVA <br>
           
           </p> 
           
          <p class="centered"> FACTURA DE VENTA  <b> No.  {{ $venta->id}}</b></p>
           
           
             <p class="w3-jumbo padding-1"><b>Fecha :</b>  {{ date('Y-m-d h:i',strtotime($venta->fecha)) }}</p>
            <p class="w3-jumbo  padding-1" style="margin:0;text-transform: uppercase;"><b>Tipo Vehiculo :</b>   {{  isset($venta->detalle_paquete->tipo_vehiculo->descripcion)? $venta->detalle_paquete->tipo_vehiculo->descripcion:'' }}</p>
            <p class="w3-jumbo  padding-1" style="margin:0;text-transform: uppercase;"><b>Placa : </b> {{ isset($venta->placa)? $venta->placa:''  }}  </p>    
            <p class="w3-jumbo  padding-1" style="margin:0;text-transform: uppercase;"><b>Cliente : </b> {{ isset($venta->nombre_cliente)? $venta->nombre_cliente:$venta->nombre_cliente }}  </p>  
            <p class="w3-jumbo  padding-1" style="margin:0;text-transform: uppercase;"><b>Numero : </b> {{ $venta->numero_telefono }}  </p>        
            <br>
            

<table>
<thead>
<tr>
            <th class="description" >CONCEPTO</th>
            <th class="description" >CANT.</th>
            <th class="description" >PRECIO</th>            
            <th class="description">$</th>            
        </tr>
</thead>
<tbody>

@php $total = 0; @endphp
                                @if($venta->detalle_paquete)
                                    @php
                                    $total += $venta->detalle_paquete->precio_venta;
                                    @endphp
                                    <tr  >
                                        <td class="description" style="text-transform: uppercase;" >{{$venta->detalle_paquete->paquete->nombre}}</td>
                                        <td  class="description">1</td>
                                        <td class="description">{{number_format($venta->detalle_paquete->precio_venta,0,',','.')}}</td>                                        
                                        <td class="description">{{number_format($venta->detalle_paquete->precio_venta,0,',','.')}}</td>
                                    </tr>
                                @endif
                                @foreach($productos as $detalle_venta_producto)
                                    @php
                                    $total += $detalle_venta_producto->total_venta;
                                    @endphp
                                    <tr  >
                                        <td class="description">{{$detalle_venta_producto->producto}}</td>
                                        <td class="description">{{$detalle_venta_producto->cantidad_vendida}}</td>
                                        <td class="description">{{ number_format($detalle_venta_producto->precio_venta,0,',','.')}}</td>                                        
                                        <td class="description">{{ number_format($detalle_venta_producto->total_venta,0,',','.')}}</td>
                                    </tr>
                                @endforeach      
</tbody>
<tfoot>
    <tr >
        <th class="description" colspan="3">TOTAL &nbsp;</th>
        <th class="description">$ {{ number_format($total,0,',','.')}}</th>
    </tr>
</tfoot>
</table>                        
            <br>
            <p class="centered"><b>¡ GRACIAS POR SU COMPRA !</b>
                
        </div>
        
        
    </body>
</html>

<!-- 
<!DOCTYPE html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Ticket-{{ $venta->id}}  </title>
        <meta name="description" content="CardWash">
        <meta name="viewport" content="width=device-width, initial-scale=1">                        
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <style type="text/css">
        .padding-1{
            padding:0  !important;            
            margin:0 !important;  
        }
        .padding-2{
            padding:2px 2px  !important;            
        }
        .size-w3{
            font-size: 26px !important;
            margin:0;
        }
        @page {            
            
           /* margin: auto; */
            padding: 0; /* Sin relleno */
            size: A3;
            font-size: 12px; /* Tamaño de fuente adecuado para impresión térmica */
        }  
        
         body {
            font-family: monospace; /* Usa una fuente monoespaciada para asegurar que los caracteres tengan el mismo ancho */
            font-size: 12px; /* Tamaño de fuente adecuado para impresión térmica */
            margin: 0; /* Sin márgenes para maximizar el espacio disponible */
            padding: 0; /* Sin relleno */
          }
        
         
      </style> 
</head>
<body> 

<div class="w3-row padding-1" >

<div class="w3-col  w3-center">
        <img class="rounded"  src="{{ asset('/icon.jpg') }}" height="450" width="400">
</div>
<div class="w3-row"  >        
    <div class="w3-col w3-center w3-jumbo padding-1" >
           <p>
            <b class="w3-jumbo ">JUANCHO'S </b> <br>
            Lavado y Mantenimiento de Vehiculos Automotores <br>
            JORGE ANDRES DIAZ CRUZ <br>          
            Nit: 1.144.189.073-3 <br>            
            No Responsable del IVA
           FACTURA DE VENTA  <b> No.  {{ $venta->id}}</b>
           </p>            
    </div>
    <div class="w3-row padding-1">
    <p class="w3-jumbo  padding-1"><b>Fecha :</b>  {{ date('Y-m-d h:i',strtotime($venta->fecha)) }}</p>
    <p class="w3-jumbo  padding-1" style="margin:0;text-transform: uppercase;"><b>Tipo Vehiculo :</b>   {{  isset($venta->detalle_paquete->tipo_vehiculo->descripcion)? $venta->detalle_paquete->tipo_vehiculo->descripcion:'' }}</p>
    <p class="w3-jumbo  padding-1" style="margin:0;text-transform: uppercase;"><b>Placa : </b> {{ isset($venta->placa)? $venta->placa:''  }}  </p>    
    <p class="w3-jumbo  padding-1" style="margin:0;text-transform: uppercase;"><b>Cliente : </b> {{ isset($venta->nombre_cliente)? $venta->nombre_cliente:$venta->nombre_cliente }}  </p>    
    <p class="w3-jumbo  padding-1" style="margin:0;text-transform: uppercase;"><b>Numero : </b> {{ $venta->numero_telefono }}  </p>        
    </div>
    
</div>
</div>



<div class="w3-row">
<table class="w3-table w3-bordered "  >
<thead>
<tr class=" w3-center" >
            <th class="w3-jumbo w3-light-grey padding-1 w3-center" >CONCEPTO</th>
            <th class=" w3-jumbo w3-light-grey padding-1 w3-center" >CANT.</th>
            <th class="w3-jumbo w3-light-grey  padding-1 w3-center" >PRECIO</th>            
            <th class="w3-jumbo w3-light-grey  padding-1 w3-center">IMPORTE</th>            
        </tr>
</thead>
<tbody>

@php $total = 0; @endphp
                                @if($venta->detalle_paquete)
                                    @php
                                    $total += $venta->detalle_paquete->precio_venta;
                                    @endphp
                                    <tr  class="w3-jumbo  padding-1 w3-center">
                                        <td class="w3-jumbo padding-1 w3-center" style="text-transform: uppercase;" >{{$venta->detalle_paquete->paquete->nombre}}</td>
                                        <td  class="w3-jumbo padding-1 w3-center">1</td>
                                        <td class="w3-jumbo padding-1 w3-center">{{number_format($venta->detalle_paquete->precio_venta,0,',','.')}}</td>                                        
                                        <td class="w3-jumbo padding-1 w3-center">{{number_format($venta->detalle_paquete->precio_venta,0,',','.')}}</td>
                                    </tr>
                                @endif
                                @foreach($productos as $detalle_venta_producto)
                                    @php
                                    $total += $detalle_venta_producto->total_venta;
                                    @endphp
                                    <tr  class="w3-jumbo  padding-1 w3-center">
                                        <td class="w3-jumbo padding-1 w3-center">{{$detalle_venta_producto->producto}}</td>
                                        <td class="w3-jumbo padding-1 w3-center">{{$detalle_venta_producto->cantidad_vendida}}</td>
                                        <td class="w3-jumbo padding-1 w3-center">{{ number_format($detalle_venta_producto->precio_venta,0,',','.')}}</td>                                        
                                        <td class="w3-jumbo padding-1 w3-center">{{ number_format($detalle_venta_producto->total_venta,0,',','.')}}</td>
                                    </tr>
                                @endforeach      
</tbody>
<tfoot>
    <tr class="w3-jumbo padding-1">
        <th class=" w3-jumbo w3-right-align  padding-1" colspan="3">TOTAL &nbsp;</th>
        <th class="w3-jumbo padding-1">$ {{ number_format($total,0,',','.')}}</th>
    </tr>
</tfoot>
</table>                        
<hr>
    <p class="w3-jumbo w3-serif  w3-center w3-margin-top" >¡ GRACIAS POR SU COMPRA ! </p>
    </div> 
    </body>
</html>


-->