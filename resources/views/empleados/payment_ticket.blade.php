<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Recibo de Pago Empleado</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f8f9fa; }
        .ticket { width: 350px; margin: 30px auto; background: #fff; border-radius: 10px; box-shadow: 0 2px 8px #007bff22; padding: 20px; }
        .ticket h2 { text-align: center; color: #007bff; }
        .ticket .info { margin-bottom: 10px; }
        .ticket .info strong { color: #333; }
        .ticket .total { font-size: 1.3em; color: #28a745; font-weight: bold; text-align: right; }
        .ticket .label { color: #888; }
        .ticket .footer { text-align: center; margin-top: 15px; color: #007bff; font-size: 0.95em; }
        .ticket .print-btn { display: block; margin: 15px auto 0 auto; }
    </style>
</head>
<body>
    <div class="ticket">
        <h2>Recibo de Pago</h2>
        <div class="info"><strong>Empleado:</strong> {{ $empleado->name }}</div>
        <div class="info"><strong>Fecha de pago:</strong> {{ $pago->fecha_pago }}</div>
        <div class="info"><strong>Servicios pagados:</strong> <span class="label">({{ $pago->total_servicios }} COP)</span></div>
        <div class="info"><strong>Préstamos descontados:</strong> <span class="label">({{ $pago->total_prestamos }} COP)</span></div>
        <div class="info"><strong>Balance anterior:</strong> <span class="label">({{ $pago->total_balance_anterior }} COP)</span></div>
        <div class="total">Total pagado: $ {{ number_format($pago->total_pagado, 0, ',', '.') }}</div>
        <div class="footer">
            ¡Gracias por tu trabajo!<br>
            Car Wash C21
        </div>
        <button class="print-btn" onclick="window.print()">Imprimir</button>
    </div>
</body>
</html>