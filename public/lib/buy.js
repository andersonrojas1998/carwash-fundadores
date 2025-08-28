var minDate, maxDate;
 
// Custom filtering function which will search data in column four between two values
$.fn.dataTable.ext.search.push(
    function( settings, data, dataIndex ) {
        var min = (minDate.val() != "")? new Date(minDate.val() + "T00:00:00") : new Date("2023-06-01T00:00:00");
        var max = (maxDate.val() != "")? new Date(maxDate.val() + "T23:59:59") : new Date();
        var date = new Date( data[1]  + "T00:00:00");
 
        if (
            ( min === null && max === null ) ||
            ( min === null && date <= max ) ||
            ( min <= date   && max === null ) ||
            ( min <= date   && date <= max )
        ) {
            return true;
        }
        return false;
    }
);

$(function(){

    minDate = $('#min');
    maxDate = $('#max');

    var table = $('#table-compra').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'csv', 'excel', 'pdf'
        ],
        ajax:{
            url: $('#table-compra').data('url'),
            method: "GET",
            headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')},
            dataSrc: function(json){
                if(!json.data){
                    return [];
                } else {
                    return json.data;
                }
            }
        },
        columnDefs: [
            //{width: "2%", target: 0},
            {"className": "text-center", "targets": "_all"},
        ],
        columns:[
            {"data": "reg_op" , render(data){ return '<b class="text-uppercase"> '+ data +'</b>' ;  }},
            {"data": "fecha_emision"},
            {"data": "compracol" ,  render(data){ return '<p class="text-uppercase text-primary"> '+ data +'</p>' ;  }},
            {"data": "no_comprobante"},
            {"data": "id_proveedor", render(data,ps,compra){                 
                return  '<p class="text-uppercase text-primary"> '+ compra.id_proveedor + '-'+ compra.id_proveedor_nombre +'</p>'                            
            }},
            {"data": "razon_social_proveedor", render(data){ return '<p class="text-default"> '+ data +'</p>' ;  }},
            {"data": "descuentos_iva"   , render(data){ return '<p class="text-uppercase"> '+ new Intl.NumberFormat().format(parseFloat(data) ) +' %</p>' ;}},
            {"data": "importe_total"},
            {"data": "estado_id", render(data){ return (data==1)? '<h4><label class="badge  badge-lg text-white badge-success">Compra</label></h4>':'<h4><label class="badge text-white badge-warning">Pago</label></h4>' }},
            {"data": "actions", render(data, ps, compra){
                let div = $('<div>', {
                    html: $("<a>", {
                        href: compra.route_edit,
                        class: "btn_show_edit_compra",
                        title: compra.title, 
                        html: $("<i>", {
                            class : "mdi mdi-pencil-box-outline text-primary mdi-24px"
                        })
                    }).attr("data-toggle", "tooltip")
                });
                return div.html();
            }
        }
        ]
    });

    // Refilter the table
    $('#min, #max').on('change', function () {
        table.draw();
    });

    $('.btn_save_edit_product_values').toggle();

    if($("#success_message").length)
        sweetMessage('\u00A1Exitoso!', $("#success_message").val());

    if($("#fail_message").length)
        sweetMessage('\u00A1Advertencia!', $("#fail_message").val(), 'error');

    var loadProductOptions = function(){
        $.ajax({
            url: $("#select-product-data-url").val(),
            type: "GET",
            processData: false,
            contentType: false,
            cache: false,
            timeout: 600000,
            headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')},
            success: function(data, textStatus, xhr){
                $('.select-product-compra').empty();
                $.each(data.data, function(i, producto){                
                    $('.select-product-compra').append($('<option>',{
                        value: producto.id,
                        text: producto.producto + " - " + producto.tipo_producto + " (" + producto.presentacion + ")"
                        //text: producto.nombre + " (presentaci\u00f3n)"
                    }));
                });
                $('.id_producto_table').each(function(){
                    $('.select-product-compra > option[value="' + $(this).val() + '"]').remove();
                });
            }
        });
    }

    loadProductOptions();

    $(document).on("keyup", ".input-quantity, .input-sell-price, .input-buy-price, #descuentos_iva_compra, #descuentos_iva_compra_edit", function(){
        if($(this).val() < 0){
            $(this).val("");
        }
    });

    $(document).on('click', ".btn_add_product", function(){
        let form = $(this).parents('form');
        if(form.find(".select-product-compra :selected").val() != '' && form.find('.input-quantity').val() != '' &&
        form.find('.input-buy-price').val() != '' ){  //&& form.find('.input-sell-price').val() != ''
            $('#products-validation-message').remove();
            let id_producto = form.find(".select-product-compra :selected").val();
            let text_producto = form.find(".select-product-compra :selected").text();
            form.find(".select-product-compra :selected").remove();
            let cantidad = parseInt(form.find('.input-quantity').val());
            form.find('.input-quantity').val('');
            let precio_compra = parseFloat(form.find('.input-buy-price').val());
            form.find('.input-buy-price').val('');
           // let precio_venta = parseFloat(form.find('.input-sell-price').val());
           // form.find('.input-sell-price').val('');
            let importe_total = parseFloat("0");

            form.find('.table-add-products > tbody').append($('<tr>',{
                html: [
                    $('<td>', {
                        html:[
                            text_producto,
                            $('<input>', {
                                type: "hidden",
                                name: "id_detalle_compra_producto[]",
                                value: -1
                            }),
                            $('<input>', {
                                type: "hidden",
                                class: "id_producto_table",
                                name: "id_producto[]",
                                value: id_producto
                            }).attr('data-text', text_producto)
                        ]
                    }),
                    $('<td>', {
                        html: [
                            cantidad,
                            $('<input>', {
                                type: "hidden",
                                class: "cantidad_producto_table",
                                name: "cantidad[]",
                                value: cantidad
                            })
                        ]
                    }),
                  /*  $('<td>', {
                        html: [
                            '$ ' + precio_venta,
                            $('<input>', {
                                type: "hidden",
                                class: "precio_venta_producto_tabla",
                                name: "precio_venta[]",
                                value: precio_venta
                            })
                        ]
                    }),*/
                    $('<td>', {
                        html: [
                            '$ ' + precio_compra,
                            $('<input>', {
                                type: "hidden",
                                class: "precio_compra_producto_table",
                                name: "precio_compra[]",
                                value: precio_compra
                            })
                        ]
                    }),
                    $('<td>',{
                        html: $('<a>',{
                            class: 'btn-remove-product',
                            html: $("<i>", {
                                class : "mdi mdi-minus-box text-danger mdi-24px"
                            })
                        })
                    })
                ]
            }));
            $('.precio_compra_producto_table').each(function(){
                console.log($(this).parent('tr').find('.cantidad_producto_table').val());
                console.log(parseFloat($(this).val()));

                console.log(parseFloat($(this).val()) * $(this).parents('tr').find('.cantidad_producto_table').val());
                importe_total += parseFloat($(this).val()) * $(this).parents('tr').find('.cantidad_producto_table').val();
            });
            form.find(".importe_total").val(importe_total);
            form.find(".text_importe_total").text(importe_total);
        }else{
            sweetMessage('\u00A1Advertencia!', '\u00A1 Por favor complete los campos!', 'warning');
        }
    });

    $(document).on('click', '.btn-remove-product', function(){
        let tr = $(this).parents('tr');
        let table = $(this).parents('table');
        table.find(".select-product-compra").append($('<option>', {
            value : tr.find('.id_producto_table').val(),
            text: tr.find('.id_producto_table').data('text')
        }));
        let precio_compra = parseInt(tr.find('.precio_compra_producto_table').val());
        let total = parseInt(table.find('.importe_total').val());
        table.find('.importe_total').val(total - precio_compra);
        table.find('.text_importe_total').text(total - precio_compra);
        tr.remove();
    });

    $('.btn_edit_product_values').on('click', function(){
        $(this).toggle();
        let tr = $(this).parents('tr');
        tr.find('.btn_save_edit_product_values').toggle();
        let quantity = tr.find('.td_quantity > input').val();
        let sell_price = tr.find('.td_sell_price > input').val();
        let buy_price = tr.find('.td_buy_price > input').val();

        tr.find('.td_quantity').html($('<input>', {
            type:"number",
            class:"form-control input-quantity",
            value: quantity,
            min: quantity
        }));
        tr.find('.td_quantity').css('width', '130px');
        tr.find('.td_quantity').css('display', 'inline-block');
        tr.find('.td_sell_price').html($('<input>', {
            type:"number",
            class:"form-control input-sell-price",
            value: sell_price
        }));
        tr.find('.td_buy_price').html($('<input>', {
            type:"number",
            class:"form-control input-buy-price",
            value: buy_price
        }));
        $("#btn_save_edit_buy").attr('disabled', true);
        $("#btn_save_edit_buy").removeClass('btn-success');
        $("#btn_save_edit_buy").addClass('btn-danger');
    });

    $('.btn_save_edit_product_values').click(function(){
        let tr = $(this).parents('tr');
        if(tr.find('.td_quantity > input').val() != "" && tr.find('.td_sell_price > input').val() != "" && tr.find('.td_buy_price > input').val() != ""){
            if(tr.find('.td_quantity > input').val() >= tr.find('.td_quantity > input').attr("min")){
                $(this).toggle();
                tr.find('.btn_edit_product_values').toggle();
                let quantity = tr.find('.td_quantity > input').val();
                let sell_price = tr.find('.td_sell_price > input').val();
                let buy_price = tr.find('.td_buy_price > input').val();
                tr.find('.td_quantity').text(quantity);
                tr.find('.td_quantity').append($('<input>', {
                    type:"hidden",
                    name:"cantidad[]",
                    value: quantity
                }));
                tr.find('.td_sell_price').text(sell_price);
                tr.find('.td_sell_price').append($('<input>', {
                    type:"hidden",
                    name:"precio_venta[]",
                    value: sell_price
                }));
                tr.find('.td_buy_price').text(buy_price);
                tr.find('.td_buy_price').append($('<input>', {
                    type:"hidden",
                    class:"precio_compra_producto_table",
                    name: "precio_compra[]",
                    value: buy_price
                }));
                let importe_total = parseFloat("0");
                $('.precio_compra_producto_table').each(function(){
                    importe_total += parseFloat($(this).val());
                });
                $(".importe_total").val(importe_total);
                $(".text_importe_total").text(importe_total);

                let table = $(this).parents('table');
                console.log(table.find('.input-quantity').length);
                if(table.find('.input-quantity').length == 1){
                    $("#btn_save_edit_buy").removeAttr('disabled');
                    $("#btn_save_edit_buy").removeClass('btn-danger');
                    $("#btn_save_edit_buy").addClass('btn-success');
                }
            }else{
                sweetMessage("¡Advertencia!", "No se puede editar la cantidad por menos de " + tr.find('.td_quantity > input').attr("min"), "warning");
                tr.find('.td_quantity > input').val(tr.find('.td_quantity > input').attr("min"));
            }
        }else{
            sweetMessage("¡Advertencia!", "Por favor complete los campos", "warning");
        }
    });

    $(document).on('click', '.btn_show_edit_compra', function(){
        $('input:radio').removeAttr('checked');
        $('#id_compra').val($(this).data('id'));
        $('#reg_op_compra_edit').val($(this).data('reg-op'));
        $('#fecha_emision_compra_edit').val($(this).data('fecha-emision'));
        $('#compracol_edit').val($(this).data('compracol'));
        $('#fecha_vencimiento_compra_edit').val($(this).data('fecha-vencimiento'));
        $('#no_comprobante_compra_edit').val($(this).data('no-comprobante'));
        $('#id_proveedor_compra_edit').val($(this).data('id-proveedor'));
        $('#edit-buy-form input[value="' + $(this).data('razon-social-proveedor') + '"]').attr("checked", true);
        $('#descuentos_iva_compra_edit').val($(this).data('descuentos-iva'));
        let importe_total = $(this).data('importe-total');
        $('#edit-buy-form .text_importe_total').text(importe_total);
        $('#edit-buy-form .importe_total').val(importe_total);
        loadProductOptions();
        $.ajax({
            url: $(this).data('url'),
            type: "GET",
            processData: false,
            contentType: false,
            cache: false,
            timeout: 600000,
            headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')},
            success: function(data, textStatus, xhr){
                $('#edit-buy-form .table-add-products > tbody').empty();
                if(data.length != 0){
                    $.each(data, function(i, det_comp_prod){
                        $('#edit-buy-form .table-add-products > tbody').append(
                            $('<tr>',{
                                html:[
                                    $('<td>', {
                                        html: [
                                            //det_comp_prod.producto.nombre + " (" + det_comp_prod.producto.presentacion.nombre + ")",
                                            det_comp_prod.producto.nombre + " (Presentaci\u00f3n)",
                                            $('<input>', {
                                                type: "hidden",
                                                class: "id_detalle_compra_producto_table",
                                                name: "id_detalle_compra_producto[]",
                                                value: det_comp_prod.id
                                            }),
                                            $('<input>', {
                                                type: "hidden",
                                                class: "id_producto_table",
                                                name: "id_producto[]",
                                                value: det_comp_prod.producto.id
                                            }).attr('data-text', det_comp_prod.producto.nombre)
                                        ]
                                    }),
                                    $('<td>', {
                                        html: [
                                            det_comp_prod.cantidad,
                                            $('<input>', {
                                                type: "hidden",
                                                class: "cantidad_producto_table",
                                                name: "cantidad[]",
                                                value: det_comp_prod.cantidad
                                            })
                                        ]
                                    }),
                                  /*  $('<td>', {
                                        html: [
                                            det_comp_prod.precio_venta,
                                            $('<input>', {
                                                type: "hidden",
                                                class: "precio_venta_producto_tabla",
                                                name: "precio_venta[]",
                                                value: det_comp_prod.precio_venta
                                            })
                                        ]
                                    }),*/
                                    $('<td>', {
                                        html: [
                                            det_comp_prod.precio_compra,
                                            $('<input>', {
                                                type: "hidden",
                                                class: "precio_compra_producto_table",
                                                name: "precio_compra[]",
                                                value: det_comp_prod.precio_compra
                                            })
                                        ]
                                    }),
                                    $('<td>',{
                                        html: $('<a>',{
                                            class: 'btn-remove-product',
                                            html: $("<i>", {
                                                class : "mdi mdi-minus-box text-danger mdi-24px"
                                            })
                                        })
                                    })
                                ]
                            })
                        );
                        let td6 = $('<td>');
                        let button_remove = $('<a>',{
                            class: 'btn-remove-product'
                        });
                        button_remove.attr('data-id', det_comp_prod.id);
                        let i2 = $("<i>", {
                            class : "mdi mdi-minus-box text-danger mdi-24px"
                        });
                        button_remove.append(i2);
                        td6.append(button_remove);
                        //tr.append(td6);
                        //$('#edit-buy-form .table-add-products > tbody').append(tr);
                        $('#edit-buy-form .select-product-compra > option[value="' + det_comp_prod.producto.id + '"]').remove();
                    });
                }
            }
        });
    });
});