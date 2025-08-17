$(function(){

    

    $('#table-sell').DataTable(
        {
        dom: 'Bfrtip',
        buttons: ['excel', 'pdf'],
        order: [[0, 'desc']]
    }
    );

    $('#input_payment_method').select2({
    templateResult: function(option) {
        if (!option.id) return option.text;
        var icon = $(option.element).data('icon');
        return $('<span><i class="' + icon + '"></i> ' + option.text + '</span>');
    },
    templateSelection: function(option) {
        if (!option.id) return option.text;
        var icon = $(option.element).data('icon');
        return $('<span><i class="' + icon + '"></i> ' + option.text + '</span>');
    }
});

    if($('#succes_message').length)
        sweetMessage('', $('#succes_message').val());

    if($('#fail_message').length)
        sweetMessage('', $('#fail_message').val(), 'error');


    $(".navbar, #sidebar, .main-panel>footer").addClass("d-print-none");

    $('.radio-btn-vehicle-type').on('change', function(){
        $.ajax({
            url: $(this).data('url'),
            type: "GET",
            processData: false,
            contentType: false,
            cache: false,
            timeout: 600000,
            headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')},
            success: function(data, textStatus, xhr){
                $("#div-packages").removeClass("d-none");
                $("#div-buttons-package").empty();
               
                $.each(data.paquetes, function(i, paquete){
                   // console.log(paquete);
                    $("#div-buttons-package").append([
                        $("<label>", {
                            class: "btn btn-outline-primary",
                            //style: "min-width:240.938px;",
                            html: [
                                $("<input>", {
                                    type: "radio",
                                    name: "id_detalle_paquete",
                                    value: paquete.id_detalle_paquete,
                                    class: "button_package"
                                }).attr({
                                    "data-price": paquete.precio,
                                    "data-percent": paquete.porcentaje,
                                    "data-id": paquete.id_detalle_paquete,
                                    "data-text" : paquete.nombre + " - " + paquete.tipo_vehiculo.descripcion
                                }),                              
                                $("<div>", {
                                    class: "card border border-dark text-center text-light",
                                    style: "border-radius: 1em; overflow:hidden; max-width:205.938px;",
                                    html: [
                                        $("<div>", {
                                            class: "card-header px-2",
                                            style: "background-color: black;",
                                            html: "<h1 class='m-0 text-uppercase'><strong>" + paquete.nombre + "</strong></h1>"
                                        }),
                                        $("<div>", {
                                            class: "card-body px-2 py-3",
                                            style: "background: linear-gradient(" + paquete.color.split(',')[0] + ", #a8a4a4); color: " + paquete.color.split(',')[1] + ";",
                                            html: [
                                                '<h2 class="m-0"><strong>' + paquete.tipo_vehiculo.descripcion + '</strong></h2>',
                                                '<h2 class="m-0"><strong>$ ' + paquete.precio + '</strong></h2>',
                                                '<hr class="my-3">',
                                                $("<strong>", {
                                                    class: "card-title",
                                                    style: "color: #fff; text-shadow: 2px 0 #000, -2px 0 #000, 0 2px #000, 0 -2px #000, 1px 1px #000, -1px -1px #000, 1px -1px #000, -1px 1px #000;",
                                                    id: "servicios-" + paquete.id,
                                                })
                                            ]
                                        })
                                    ]
                                })
                            ]
                        }),
                    ]);
                    $.each(paquete.servicios_paquete, function(j, servicio_paquete){
                        $("#servicios-" + paquete.id).append(servicio_paquete.servicio.nombre);
                        if(paquete.servicios_paquete[j+1]){
                            $("#servicios-" + paquete.id).append(" - ");
                        }
                    })
                });
            }
        });
    });



    if($('.edit-sell').length){

        var pack=$('.edit-sell').attr('data-pack');

        $.ajax({
            url: $('.edit-sell').attr('data-url-old'),
            type: "GET",
            processData: false,
            contentType: false,
            cache: false,
            timeout: 600000,
            headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')},
            success: function(data, textStatus, xhr){
                $("#div-packages").removeClass("d-none");
                $("#div-buttons-package").empty();                               
                $.each(data.paquetes, function(i, paquete){                      
                    var conditional="";                
                    if(parseInt(paquete.id) == parseInt(pack)){                        
                        conditional+=" active";                                                                          
                    }
                    $("#div-buttons-package").append([
                        $("<label>", {
                            class: "btn btn-outline-primary" + conditional ,                            
                            html: [
                                $("<input>", {
                                    type: "radio",
                                    name: "id_detalle_paquete",
                                    value: paquete.id_detalle_paquete,
                                    class: "button_package" 
                                }).attr({
                                    "data-cc":conditional,
                                    "data-price": paquete.precio,
                                    "data-percent": paquete.porcentaje,
                                    "data-id": paquete.id_detalle_paquete,
                                    "data-text" : paquete.nombre + " - " + paquete.tipo_vehiculo.descripcion
                                }),                              
                                $("<div>", {
                                    class: "card border border-dark text-center text-light",
                                    style: "border-radius: 1em; overflow:hidden; max-width:205.938px;",
                                    html: [
                                        $("<div>", {
                                            class: "card-header px-2",
                                            style: "background-color: black;",
                                            html: "<h1 class='m-0 text-uppercase'><strong>" + paquete.nombre + "</strong></h1>"
                                        }),
                                        $("<div>", {
                                            class: "card-body px-2 py-3",
                                            style: "background: linear-gradient(" + paquete.color.split(',')[0] + ", #a8a4a4); color: " + paquete.color.split(',')[1] + ";",
                                            html: [
                                                '<h2 class="m-0"><strong>' + paquete.tipo_vehiculo.descripcion + '</strong></h2>',
                                                '<h2 class="m-0"><strong>$ ' + paquete.precio + '</strong></h2>',
                                                '<hr class="my-3">',
                                                $("<strong>", {
                                                    class: "card-title",
                                                    style: "color: #fff; text-shadow: 2px 0 #000, -2px 0 #000, 0 2px #000, 0 -2px #000, 1px 1px #000, -1px -1px #000, 1px -1px #000, -1px 1px #000;",
                                                    id: "servicios-" + paquete.id,
                                                })
                                            ]
                                        })
                                    ]
                                })
                            ]
                        }),
                    ]);

                    if(parseInt(paquete.id) == parseInt(pack)){                        
                        $('input[name="id_detalle_paquete"][value='+parseInt(paquete.id_detalle_paquete)+']').prop("checked",true).click(); 
                    }                    
                    $.each(paquete.servicios_paquete, function(j, servicio_paquete){
                        $("#servicios-" + paquete.id).append(servicio_paquete.servicio.nombre);
                        if(paquete.servicios_paquete[j+1]){
                            $("#servicios-" + paquete.id).append(" - ");
                        }
                    });

                });                
            }
        });
    }


    



    $(document).on("click", ".button_package", function(){
                
        if(!$("#tr-package").is(":empty")){
            $("#importe_total").val(parseFloat($("#importe_total").val()) - $("#tr-package .btn-remove-package").data("total"));
        }
        $("#tr-package").html([
            $("<td>", {
                html: [
                    $(this).data("text")
                ]
            }),
            $("<td>", {
                text: "$ " + $(this).data("price")
            }),
            $("<td>", {
                text: 1
            }),
            $("<td>", {
                text: "$ " + $(this).data("price")
            }),
            $("<input>", {
                type: "hidden",
                name: "precio_venta_paquete",
                value: $(this).data("price"),
               
            }),
            $("<input>", {
                type: "hidden",
                name: "porcentaje_paquete",
                value: $(this).data("percent"),                              
            }),
            $("<td>", {
                html: $('<a>',{
                    class: 'btn-remove-package',
                    html: $("<i>", {
                        class : "mdi mdi-minus-box text-danger mdi-24px"
                    })



                    
                }).attr({
                    "data-id": $(this).val(),
                    "data-total": $(this).data("price")
                })
            })
        ]);
        $("#importe_total").val(parseFloat($("#importe_total").val()) + parseFloat($(this).data("price")));
        $("#text_importe_total").text($("#importe_total").val());
    });

    $(document).on('click', '.btn-remove-package', function(){
        let tr = $(this).parents('tr');
        $(".button_package[value='" + $(this).data('id') + "']").prop('checked', false).trigger("change");
        $(".button_package[value='" + $(this).data('id') + "']").parent("label").removeClass("active");

        $("#importe_total").val(parseFloat($("#importe_total").val()) - parseFloat($(this).data("total")));
        $("#text_importe_total").text($("#importe_total").val());
        tr.empty();
    });

    $(document).on("change", "#select-product", function(){
        if($(this).val() != ""){
            $("#input-quantity-available-product").val($(this).find(":selected").data('quantity'));
        }
    });

    $(document).on("click", "#btn-add-products", function(){
        if($("#select-product").val() != '' && $("#input-quantity-product").val() != ""){
            if($("#input-quantity-product").val() != 0){
                if(parseInt($("#input-quantity-product").val()) <= parseInt($("#input-quantity-available-product").val())){
                    let total = parseFloat($("#select-product :selected").data("price")) * parseFloat($("#input-quantity-product").val());
                    let margen_ganancia = parseFloat($("#select-product :selected").data("price")) - parseFloat($("#select-product :selected").data("buy-price"));
                    $("#table-products tbody").append(
                        $("<tr>", {
                            html: [
                                $("<td>",{
                                    html: [
                                        $("#select-product :selected").data("text"),
                                        $("<input>", {
                                            type: "hidden",
                                            name: "id_producto[]",
                                            value: $("#select-product").val(),
                                        })
                                    ]
                                }),
                                $("<td>",{
                                    html: [
                                        "$ " + $("#select-product :selected").data("price"),
                                        $("<input>", {
                                            type: "hidden",
                                            name: "precio_venta[]",
                                            value: $("#select-product :selected").data("price"),
                                        }),
                                        $("<input>", {
                                            type: "hidden",
                                            name: "margen_ganancia[]",
                                            value: margen_ganancia,
                                        })
                                    ]
                                }),
                                $("<td>",{
                                    html: [
                                        $("#input-quantity-product").val(),
                                        $("<input>", {
                                            type: "hidden",
                                            name: "cantidad[]",
                                            value: $("#input-quantity-product").val(),
                                        })
                                    ]
                                }),
                                $("<td>",{
                                    text: "$ " + total
                                }),
                                $("<td>",{
                                    html: [
                                        $('<a>',{
                                            class: 'btn-remove-product',
                                            html: $("<i>", {
                                                class : "mdi mdi-minus-box text-danger mdi-24px"
                                            })
                                        }).attr({
                                            "data-id": $("#select-product").val(),
                                            "data-text": $("#select-product :selected").data("text"),
                                            "data-quantity": $("#select-product :selected").data("quantity"),
                                            "data-price": $("#select-product :selected").data("price"),
                                            "data-total": total
                                        })
                                    ]
                                }),
                            ]
                        })
                    );
                    $("#select-product :selected").remove().trigger("change");
                    $("#importe_total").val(parseFloat($("#importe_total").val()) + parseFloat(total));
                    $("#text_importe_total").text($("#importe_total").val());
                    $("#input-quantity-available-product").val("");
                    $("#input-quantity-product").val("");
                }else{
                    sweetMessage('¡Advertencia!', 'La cantidad ingresada supera la disponible', 'warning');
                }
            }else{
                sweetMessage('¡Advertencia!', 'La cantidad no es valida', 'warning');
            }
        }else{
            sweetMessage('¡Advertencia!', 'Por favor complete los campos requeridos para el producto', 'warning');
        }
    });

    $(document).on('click', '.btn-remove-product', function(){
        let tr = $(this).parents('tr');
        $("#select-product").append($('<option>', {
            value : $(this).data("id"),
            text: $(this).data('text') + " - $ " + $(this).data("price")
        }).attr({
            "data-price": $(this).data("price"),
            "data-quantity": $(this).data("quantity"),
            "data-text": $(this).data("text")
        }));
        $("#importe_total").val(parseFloat($("#importe_total").val()) - parseFloat($(this).data("total")));
        $("#text_importe_total").text($("#importe_total").val());
        tr.remove();
    });

    $(document).on("change", "#type-sale", function(){
        if($(this).val() == 1){
            $("#card-vehicle-type").toggle();
        }else{
            $("#card-vehicle-type").toggle();
        }
    });

    $(document).on("click","#btn_show_change_user",function(){ 
        let id=$(this).attr('data-id');
        $('#id_venta').val($(this).attr('data-venta'));
        $('#user_service >option[value='+ id +']').attr('selected',true).trigger('change'); 
    });
    $(document).on("click",".btn_user_service",function(){ 
        let id_user=$('#user_service').val();
        let id_venta=$('#id_venta').val();

        $.ajax({
            url:'/update_user',
            type: "POST",
            data:{'id_user':id_user,'id_venta':id_venta},
            headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')},            
            success:function(data){
                if(data==1){
                    sweetMessage('\u00A1Registro exitoso!', '\u00A1 Se ha realizado con \u00E9xito su solicitud!');
                    setTimeout(function () { location.reload() }, 2000)
                   }
            }

        })

    });
    
    $(document).on("click",".btn_generateTicket",function(){ 
        let venta=$(this).attr('data-id');
        
            let url='/ticketPrint/'+venta;
            var xhr = new XMLHttpRequest();
            xhr.open("GET",url);
            xhr.responseType = 'arraybuffer';           
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); 
            xhr.send(null);
            sweetMessageTimeOut('Procesando ...', '\u00A1  Su solicitud  se encuentra en ejecuci\u00F3n ! ',5000);
            xhr.onreadystatechange = function () {
                
                if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
                                        
                    var blobURL = new Blob([this.response], {type:'text/html'});

             
                    var link = document.createElement('a');                    
                    link.href = window.URL.createObjectURL(blobURL);                                       
                  //  var objFra = window.open(link,"theFrame");

                    //console.log(link);

                  /*  var newurl = window.URL.createObjectURL(blobURL);
                    document.getElementById("theFrame").src = newurl;*/
                   // printWindow.location.reload();
                 
                  /* var external_doc = new Blob(['<html><body><img src="https://78.media.tumblr.com/b90ee054017d4ddd25a4c4161127c7d4/tumblr_p8iyzdMhuZ1qzooxpo1_1280.jpg"></body></html>'], {
                    type: 'text/html'
                  });*/


                   var objFra = document.createElement('iframe'); // Create an IFrame.
                    objFra.style.visibility = "hidden"; // Hide the frame.objFra.style.visibility = "hidden"; // Hide the frame.                   
                   // objFra.src =link; // Set source not done .pdf.
                  /*  objFra.onload = function(){
                    objFra.contentWindow.focus(); // Set focus.
                    objFra.contentWindow.print(); // Print it  
                    };
                    document.body.appendChild(objFra);*/



                    objFra.onload = function() {
                        try {
                          this.contentWindow && this.contentWindow.print();
                          return;
                        } catch (e) {}
                        console.error('in a protective iframe?');
                      };
                      objFra.src = URL.createObjectURL(blobURL);
                      document.body.appendChild(objFra);



                    
                   // printWindow.print();
                
                    //Close window once print is finished
                  /* printWindow.onafterprint = function(){
                       printWindow.close()
                    };*/
                    //window.location.hash = '';

                  //  sweetMessage('\u00A1Registro exitoso!', '\u00A1 Se ha realizado con \u00E9xito su solicitud!');
                }
                if (this.status === 500) { sweetMessage("ERROR!", "Error al generar el pdf !", "error", "#1976D2", false); }
            }
                               
    });

});

function printIframe() {       
    var iframe = document.getElementById('theFrame');       
    var iframeWindow = iframe.contentWindow;       
    iframeWindow.focus();       
    iframeWindow.print();     
  }

$(document).on('blur', '#input_license_plate', function() {
    let placa = $(this).val().trim();
    if (placa !== '') {
        $.ajax({
            url: '/buscar-cliente-placa',
            type: 'GET',
            data: { placa: placa },
            headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
            success: function(data) {
                if (data && data.success && data.cliente) {
                    $('#input_name_customer').val(data.cliente.nombre_cliente);
                    $('#input_phone_number').val(data.cliente.numero_telefono);
                } else {
                    $('#input_name_customer').val('');
                    $('#input_phone_number').val('');
                }
            }
        });
    }
});


