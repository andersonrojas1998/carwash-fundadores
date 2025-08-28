$(function () {

    if ($('#succes_message').length){
        sweetMessage('', $('#succes_message').val());
    }

    if ($('#fail_message').length){
        sweetMessage('', $('#fail_message').val(), 'error');
    }

    $('.checkbox_vehicle_type').removeClass('disabled');

    $(document).on("change","#select-package", function(){
        $.ajax({
            url: $(this).find(':selected').data('url'),
            type: "GET",
            processData: false,
            contentType: false,
            cache: false,
            timeout: 600000,
            headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')},
            error: function(jqXHR, textStatus, errorThrown){
                sweetMessage('', jqXHR.responseText, 'warning');
            },
            success: function(data, textStatus, xhr){
                let cheboxes = $('<div>');
                $.each(data.tipos_vehiculo, function(i, tipo_vehiculo){
                    cheboxes.append(
                        $("<label>",{
                            class: "btn btn-outline-primary",
                            html: [
                                $("<input>", {
                                    type: "radio",
                                    class: "checkbox_vehicle_type",
                                    name: "id_tipo_vehiculo",
                                    value: tipo_vehiculo.id
                                }).attr("data-name", tipo_vehiculo.descripcion),
                                $("<img>", {
                                    src: tipo_vehiculo.img_url,
                                    class: "rounded",
                                    alt: tipo_vehiculo.descripcion,
                                    title: tipo_vehiculo.descripcion,
                                    height: "90px",
                                    width: "140px"
                                }).attr("data-toggle", "tooltip")
                            ]
                        })
                    );
                });
                $("#buttons-vehicle-type").html(cheboxes.html());
                $("#div_vehicle_type").removeClass('d-none');
            }
        });
    });

    $(document).on('click', '.checkbox_vehicle_type',function () {
        if ($(this).prop('checked')) {
            $("#div_services").removeClass('d-none');

            $('#nav-add-services').empty();
            $('#tab-add-services').empty();

            $("#nav-add-services").append($('<li>', {
                class: 'nav-item',
                id: "nav-services-" + $(this).val(),
                html: $('<a>', {
                    class: 'nav-link active',
                    href: "#tab-services-" + $(this).val(),
                    text: $(this).data('name')
                }).attr('data-toggle', 'tab')
            }));

            $("#tab-add-services").html(
                $("<div>", {
                    class: "tab-pane container active",
                    id: "tab-services-" + $(this).val(),
                    html: [
                        $("<div>", {
                            class: "d-flex justify-content-around mt-3",
                            html: [
                                $("<div>", {
                                    class: "col-lg-4",
                                    html: [
                                        $("<label>", {
                                            text: "Precio de venta"
                                        }),
                                        $("<input>", {
                                            type: "number",
                                            class: "form-control",
                                            id: "sell_price_" + $(this).val(),
                                            name: "precio_venta"
                                        })
                                    ]
                                }),
                                $("<div>", {
                                    class: "col-lg-4",
                                    html: [
                                        $("<label>", {
                                            text: "Porcentaje trabajador"
                                        }),
                                        $("<input>", {
                                            type: "number",
                                            class: "form-control",
                                            id: "worker_percentage_" + $(this).val(),
                                            name: "porcentaje"
                                        })
                                    ]
                                })
                            ]
                        }),
                        $("<div>", {
                            class: "d-flex justify-content-center mt-3",
                            html: [
                                $("<div>", {
                                    class: "col-lg-6",
                                    html: [
                                        $("<label>", {
                                            text: "Servicios"
                                        }),
                                        $("<select>", {
                                            class: "custom-select",
                                            id: "select_service",
                                            html: $("#options-for-services").html()
                                        })
                                    ]
                                }),
                                $("<div>", {
                                    class: "col-lg-2",
                                    html: [
                                        $("<div>", {
                                            class: "row text-light",
                                            text: "*"
                                        }),
                                        $("<div>", {
                                            class: "d-flex justify-content-end pt-2",
                                            html: $("<button>", {
                                                type: "button",
                                                id: 'button-add-services',
                                                class: 'btn btn-success button-add-services',
                                                text: 'Agregar'
                                            }).attr('data-key', $(this).val())
                                        })
                                    ]
                                })
                            ]
                        }),
                        $('<div>', {
                            class: 'row mt-4',
                            html: $('<div>', {
                                class: 'table-responsive',
                                html: $("<table>", {
                                    id: "table-services",
                                    class: "table table-striped text-center",
                                    html: [
                                        '<thead><tr><th>Nombre</th><th>Acci&oacute;n</th></tr></thead>',
                                        '<tbody></tbody>'
                                    ]
                                })
                            })
                        })
                    ]
                })
            );
            $("#select_service").select2();
        }
    });

    $(document).on("click", "#button-add-services", function(){
        if($("#select_service").val() != null){
            let id_servicio = $("#select_service").val();
            let text_servicio = $("#select_service :selected").text();
            $("#removed-services input[value='" + id_servicio + "']").remove();
            $("#select_service :selected").remove();
            $("#table-services tbody").append(
                $("<tr>",{
                    html: [
                        $("<td>",{
                            html: [
                                text_servicio,
                                $("<input>", {
                                    type: "hidden",
                                    value: id_servicio,
                                    name: "id_servicio[]"
                                })
                            ]
                        }),
                        $("<td>", {
                            html: $('<a>',{
                                class: 'btn-remove-service',
                                html: $("<i>", {
                                    class : "mdi mdi-minus-box text-danger mdi-24px"
                                })
                            }).attr({
                                "data-text": text_servicio,
                                "data-id": id_servicio
                            })
                        })
                    ]
                })
            );
        }
    });

    $(document).on('click', '.btn-remove-service', function(){
        let tr = $(this).parents('tr');

        $("#select_service").prepend(
            $("<option>", {
                text: $(this).data('text'),
                value: $(this).data("id")
            })
        );
        $("#select_service").val($(this).data('id'));
        $("#select_service").trigger('change.select2');

        $("#removed-services").append(
            $("<input>", {
                type: "hidden",
                name: "id_servicio_removed[]",
                value: $(this).data('id')
            })
        );
        tr.remove();
    });

    $(document).on('click', '#save-package', function(){
        let funTransitions = function(){
            if(!$('#save-package').attr('disabled')){
                $('#save-package').attr('disabled', true);
                $('#form-fields-package').addClass('d-none');
                $('#spinner-package').removeClass('d-none');
            }else{
                $('#save-package').attr('disabled', false);
                $('#form-fields-package').removeClass('d-none');
                $('#spinner-package').addClass('d-none');
            }
        }
        funTransitions();
        let formData = new FormData($('#create-package-form')[0]);
        $.ajax({
            url: $('#create-package-form').attr('action'),
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            cache: false,
            timeout: 600000,
            headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')},
            error: function(jqXHR, textStatus, errorThrown){
                funTransitions();
                if(jqXHR.status == 422){
                    let res = jqXHR.responseJSON.errors;
                    let output = '';
                    $.each(res, function(i, value){
                        output += value + '\n';
                    });
                    sweetMessage('', output, 'warning');
                }else{
                    sweetMessage('', jqXHR.responseText, 'warning');
                }
            },
            success: function(data, textStatus, xhr){
                funTransitions();
                $(':input','#create-package-form').val('');
                $("#select-package option[value='']").remove();
                $('#select-package').prepend($('<option>',{
                    value: data.paquete.id,
                    text: data.paquete.nombre
                }).attr('data-url', data.paquete.url));
                $('#select-package').val(data.paquete.id).trigger('change');
                sweetMessage('', data.success);
            }
        });
    });

    $('.disabled-elements').removeAttr("disabled");

    if($('#old-select-package').length)
        $('#select-package').val($('#old-select-package').val()).trigger('change');
});