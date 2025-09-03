@extends('layout.master')
@section('content')
<div class="container-fluid mt-4">
    <div class="row mb-3">
        <div class="col-12 col-md-8">
            <h2 class="mb-1 font-weight-bold text-primary">Cierre de Ventas y Caja</h2>
            <div class="alert alert-info p-2 mb-2">
                <i class="mdi mdi-information-outline"></i>
                <b>TIP:</b> Revisa siempre los <b>préstamos/descuentos</b> y los <b>pagos pendientes</b> antes de entregar el dinero al jefe. ¡Así evitas descuadres!
            </div>
        </div>
        <div class="col-12 col-md-4 text-md-right">
            <form id="form-fechas" class="form-inline justify-content-end">
                <label for="fecha_ini" class="mr-2">Desde:</label>
                <input type="date" id="fecha_ini" class="form-control mr-2 mb-2 mb-md-0" required>
                <label for="fecha_end" class="mr-2">Hasta:</label>
                <input type="date" id="fecha_end" class="form-control mr-2 mb-2 mb-md-0" required>
                <button type="submit" class="btn btn-primary">Consultar</button>
            </form>
        </div>
    </div>
    <div id="reporte-ventas"></div>
</div>
@endsection

@push('custom-scripts')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
$(function(){
    $('#form-fechas').on('submit', function(e){
        e.preventDefault();
        let ini = $('#fecha_ini').val();
        let end = $('#fecha_end').val();
        if(!ini || !end) return;
        $.get(`/reports/sales_summary/${ini}/${end}`, function(data){
            let html = `
                <div class="row">
                    <div class="col-lg-4 col-md-6 mb-3">
                        <div class="card shadow-sm border-0">
                            <div class="card-body">
                                <h5 class="card-title text-success mb-2"><i class="bi bi-cash-stack"></i> Total Ventas</h5>
                                <h3 class="font-weight-bold">$ ${parseInt(data.ventas_totales.total).toLocaleString('es-CO')}</h3>
                                <div class="text-muted small">Cantidad de ventas: <b>${data.ventas_totales.cantidad}</b></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 mb-3">
                        <div class="card shadow-sm border-0">
                            <div class="card-body">
                                <h5 class="card-title text-danger mb-2"><i class="bi bi-person-dash"></i> Préstamos/Descuentos</h5>
                                <h3 class="font-weight-bold text-danger">$ ${parseInt(data.total_loans).toLocaleString('es-CO')}</h3>
                                <div class="text-muted small">Ver detalle abajo</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12 mb-3">
                        <div class="card shadow-sm border-0">
                            <div class="card-body">
                                <h5 class="card-title mb-2"><i class="bi bi-wallet2"></i> Ingresos por Medio de Pago</h5>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span><i class="bi bi-cash-coin text-success"></i> Efectivo</span>
                                        <span class="badge badge-success badge-pill">$ ${parseInt(data.ventas_por_medio.Efectivo).toLocaleString('es-CO')}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span><i class="bi bi-bank text-info"></i> Transferencia</span>
                                        <span class="badge badge-info badge-pill">$ ${parseInt(data.ventas_por_medio.Transferencia).toLocaleString('es-CO')}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span><i class="bi bi-clock-history text-warning"></i> Pendiente Pago</span>
                                        <span class="badge badge-warning badge-pill">$ ${parseInt(data.ventas_por_medio.pendiente_pago).toLocaleString('es-CO')}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span><i class="bi bi-credit-card-2-front text-secondary"></i> Otro</span>
                                        <span class="badge badge-secondary badge-pill">$ ${parseInt(data.ventas_por_medio.Otro).toLocaleString('es-CO')}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-lg-7 mb-3">
                        <div class="card shadow-sm border-0">
                            <div class="card-body">
                                <h5 class="card-title mb-3"><i class="bi bi-bar-chart-line"></i> Ingresos por Día</h5>
                                <canvas id="ventasDiaChart" height="120"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5 mb-3">
                        <div class="card shadow-sm border-0">
                            <div class="card-body">
                                <h5 class="card-title mb-3"><i class="bi bi-person-dash"></i> Préstamos/Descuentos realizados</h5>
                                <div class="table-responsive">
                                    <table class="table table-sm table-bordered mb-0">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>ID</th>
                                                <th>Empleado</th>
                                                <th>Valor</th>
                                                <th>Concepto</th>
                                                <th>Fecha</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            ${data.loans.length === 0 ? `<tr><td colspan="5" class="text-center text-muted">Sin préstamos/Descuentos en este periodo</td></tr>` : data.loans.map(l => `
                                                <tr>
                                                    <td>${l.id}</td>
                                                    <td>${l.empleado}</td>
                                                    <td class="text-danger">$ ${parseInt(l.valor).toLocaleString('es-CO')}</td>
                                                    <td>${l.concepto}</td>
                                                    <td>${l.fecha_prestamo}</td>
                                                </tr>
                                            `).join('')}
                                        </tbody>
                                    </table>
                                </div>
                                <div class="alert alert-warning mt-2 mb-0 p-2 small">
                                    <i class="bi bi-exclamation-triangle"></i>
                                    <b>Importante:</b> Suma los préstamos/descuentos al cierre para entregar el monto correcto.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            $('#reporte-ventas').html(html);

            // Gráfico de ventas por día
            if (window.ventasDiaChart && typeof window.ventasDiaChart.destroy === 'function') {
                window.ventasDiaChart.destroy();
            }
            let ctx = document.getElementById('ventasDiaChart').getContext('2d');
            window.ventasDiaChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: data.dias,
                    datasets: [{
                        label: 'Ingresos por Día',
                        data: data.montos,
                        backgroundColor: '#007bff'
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: { beginAtZero: true }
                    }
                }
            });
        });
    });
});
</script>
@endpush