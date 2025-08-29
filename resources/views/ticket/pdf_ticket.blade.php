<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Ticket-{{ $venta->id }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        @page {
            margin: 0;
            size: 58mm auto;
        }
        html, body {
            width: 48mm;
            max-width: 48mm;
            margin: 0;
            padding: 0;
            font-size: 10px;
            font-family: 'Segoe UI', Arial, sans-serif;
            background: #f8f9fa;
        }
        .ticket-container {
            background: #fff;
            margin: 0;
            padding: 0;
            border-radius: 8px;
            box-sizing: border-box;
            box-shadow: 0 2px 8px #007bff22;
        }
        .center {
            text-align: center;
        }
        .brand-logo {
            margin-top: 8px;
            margin-bottom: 2px;
        }
        .brand-logo img {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            box-shadow: 0 2px 6px #007bff33;
        }
        .brand {
            font-size: 15px;
            letter-spacing: 1px;
            color: #007bff;
            font-weight: bold;
            margin-bottom: 1px;
        }
        .subtitle {
            font-size: 11px;
            color: #28a745;
            margin-bottom: 2px;
            font-weight: bold;
        }
        .info {
            font-size: 9px;
            color: #555;
            margin-bottom: 2px;
        }
        .factura {
            font-size: 11px;
            color: #222;
            margin: 7px 0 2px 0;
            font-weight: bold;
            letter-spacing: 1px;
        }
        hr {
            border: none;
            border-top: 1px dashed #007bff;
            margin: 7px 0;
        }
        .details {
            margin-bottom: 7px;
            font-size: 9px;
        }
        .details span {
            display: inline-block;
            min-width: 44px;
            color: #222;
            font-weight: 500;
        }
        .ticket-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 7px;
            font-size: 9px;
        }
        .ticket-table th, .ticket-table td {
            padding: 2px 0;
            text-align: center;
        }
        .ticket-table th {
            background: #e3f2fd;
            color: #007bff;
            font-size: 9.5px;
            border-bottom: 1px solid #007bff;
            font-weight: bold;
        }
        .ticket-table td {
            border-bottom: 1px dashed #bbb;
        }
        .total-row th, .total-row td {
            border-top: 2px solid #007bff;
            font-size: 11px;
            background: #f1f3f4;
            color: #222;
            font-weight: bold;
        }
        .footer {
            margin-top: 10px;
            text-align: center;
            font-size: 10px;
            color: #007bff;
            font-weight: bold;
            letter-spacing: 1px;
        }
        .thanks {
            font-size: 12px;
            color: #28a745;
            margin-top: 8px;
            font-weight: bold;
            letter-spacing: 1px;
            text-align: center;
        }
        .small {
            font-size: 8px;
            color: #888;
        }
        .highlight {
            color: #ff9800;
            font-weight: bold;
        }
        .contact {
            font-size: 9px;
            color: #333;
            margin-top: 4px;
        }
        .qr {
            margin: 8px 0 0 0;
            text-align: center;
        }
        .qr img {
            width: 38px;
            height: 38px;
        }
    </style>
</head>
<body>
    <div class="ticket-container">
        <div class="center">
            <div class="brand-logo">
                <img src="{{ asset('/icon.png') }}" alt="Logo Car Wash">
            </div>
            <div class="brand">Car Wash - LOS FUNDADORES</div>
            <div class="subtitle">¡Tu auto limpio, tu día feliz!</div>
            <div class="info" style="font-weight:bold;">No Responsable del IVA</div>
            <div class="factura">FACTURA DE VENTA No. {{ $venta->id }}</div>
        </div>
        <hr>
        <div class="details">
            <div><span>Fecha:</span> {{ date('Y-m-d H:i', strtotime($venta->fecha)) }}</div>
            <div><span>Vehículo:</span> {{ $venta->detalle_paquete->tipo_vehiculo->descripcion ?? '' }}</div>
            <div><span>Placa:</span> {{ $venta->placa ?? '' }}</div>
            <div><span>Cliente:</span> {{ $venta->cliente->nombre ?? '' }}</div>
            <div><span>Teléfono:</span> {{ $venta->cliente->telefono }}</div>
            <div><span>Medio Pago:</span> {{ $venta->medio_pago }}</div>            
        </div>
        <hr>
        <table class="ticket-table">
            <thead>
                <tr>
                    <th>CONCEPTO</th>
                    <th>CANT.</th>
                    <th>PRECIO</th>
                    <th>IMPORTE</th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0; @endphp
                @if($venta->detalle_paquete)
                    @php $total += $venta->total_venta; @endphp
                    <tr>
                        <td>{{ $venta->detalle_paquete->paquete->nombre }}</td>
                        <td>1</td>
                        <td>{{ number_format($venta->detalle_paquete->precio_venta, 0, ',', '.') }}</td>
                        <td>{{ number_format($venta->detalle_paquete->precio_venta, 0, ',', '.') }}</td>
                    </tr>
                @endif
                @foreach($productos as $detalle_venta_producto)
                    @php $total += $detalle_venta_producto->total_venta; @endphp
                    <tr>
                        <td>{{ $detalle_venta_producto->producto }}</td>
                        <td>{{ $detalle_venta_producto->cantidad_vendida }}</td>
                        <td>{{ number_format($detalle_venta_producto->precio_venta, 0, ',', '.') }}</td>
                        <td>{{ number_format($detalle_venta_producto->total_venta, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="total-row">
                    <th colspan="3" class="right">TOTAL</th>
                    <th>$ {{ number_format($total, 0, ',', '.') }}</th>
                </tr>
            </tfoot>
        </table>
        <div class="thanks">¡GRACIAS POR TU PREFERENCIA!</div>
        <div class="footer">
            <div>¡Vuelve pronto! <span class="highlight">Car Wash </span></div>            
        </div>
        
    </div>
</body>
</html>