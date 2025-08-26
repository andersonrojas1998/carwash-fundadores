$(document).ready(function() {
    // Abrir modal para nuevo préstamo
    $('.btn-success[data-target="#mdl_loans"]').on('click', function() {
        $('#form_loans')[0].reset();
        $('#loan_id').val('');
        $('#form_loans').attr('action', '/loans/store');
        $('#form_loans').find('input[name="_method"]').remove();
        $('#modalTitle').text('Registrar Préstamo');
        $('#btnSaveLoan').text('Registrar');
    });

    // Guardar o actualizar préstamo
    $('#form_loans').on('submit', function(e) {
        e.preventDefault();
        let form = $(this);
        let id = $('#loan_id').val();
        let url = id ? '/loans/' + id : '/loans';
        let method = id ? 'PUT' : 'POST';

        // Si es edición, agrega el campo _method
        if (id && form.find('input[name="_method"]').length === 0) {
            form.append('<input type="hidden" name="_method" value="PUT">');
        } else if (!id) {
            form.find('input[name="_method"]').remove();
        }

        $.ajax({
            url: url,
            method: 'POST',
            data: form.serialize(),
            success: function(response) {
                location.reload();
            },
            error: function(xhr) {
                alert('Error al guardar el préstamo');
            }
        });
    });

    // Editar préstamo
    $('.btn-edit-loan').on('click', function() {
    
        let id = $(this).data('id');
        $.get('/loans/' + id + '/edit', function(data) {
            $('#mdl_loans').modal('show');
            $('#modalTitle').text('Editar Préstamo');
            $('#btnSaveLoan').text('Actualizar');
            $('#loan_id').val(id);
            $('#id_usuario').val(data.id_usuario).trigger('change');
            $('#valor').val(data.valor);
            $('#concepto').val(data.concepto);
            $('#fecha_prestamo').val(data.fecha_prestamo);
            $('#fecha_pago').val(data.fecha_pago);
            $('#form_loans').attr('action', '/loans/' + id);
            if ($('#form_loans').find('input[name="_method"]').length === 0) {
                $('#form_loans').append('<input type="hidden" name="_method" value="PUT">');
            }
        });
    });

    // Eliminar préstamo
    $('.btn-delete-loan').on('click', function() {
        if (!confirm('¿Seguro que deseas eliminar este préstamo?')) return;
        let id = $(this).data('id');
        $.ajax({
            url: '/loans/' + id,
            method: 'POST',
            data: {
                _method: 'DELETE',
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function() {
                location.reload();
            },
            error: function() {
                alert('Error al eliminar el préstamo');
            }
        });
    });
});