$(document).ready(function() {


     $('#clientes-table').DataTable({
         dom: 'Bfrtip',
        buttons: [
            'csv', 'excel', 'pdf'
        ],
        ajax: {
            url: '/clientes',
            type: 'GET',
            dataSrc: 'data'
        },
        columns: [
            { data: 'no' },
            { data: 'nombre_cliente',
                render: function(data, type, row) {
                    return  data;
                }
             },
            { data: 'numero_telefono' },
            { data: 'placa' , render: function(data, type, row) {
                return '<h4><label class="badge text-black badge-warning">' + data + '</label></h4>';
                }
            },
            { data: 'tipo_vehiculo' },
            { data: 'cantidad_servicios' }
        ],
        responsive: true,
        language: {
            url: '/assets/js/spanish.json'
        }
    });


});