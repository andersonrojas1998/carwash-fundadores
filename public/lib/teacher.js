$(document).ready(function() {

    if($('#dt_teacher').length){
        dt_teacher();
    }
    
    if($('#dt_sales_user').length){
        dt_sales_user();
    }


    $(document).on("click",".btn_search_income_store",function(){ 
        var dateini=$("#date_ini").val();
        var dateend=$("#date_end").val();
        console.log(dateini,dateend);

        $.ajax({
            url:'/income_store/'+dateini+'/'+dateend,
            type:"GET",            
            dataType:"JSON",
            success:function(data){
                $(".tbl-tt_prd_qq").html(data.tt_prd_qq);
                $(".tbl-tt_prd").html(data.tt_prd);
                $(".tbl-income-service").html(data.service);
                $(".tbl-income-prd").html(data.product);
                $(".tbl-income-tt").html(data.total);
            }
        });

    });     
    
    


    $(document).on("click","#btn_show_user",function(){  
        let id=$(this).attr('data-id');
        $.ajax({
            url:"/usuarios/show/"+id,
            type:"GET",
            dataType:"JSON",
            success:function(data){
                $("#id_user").val(data.id);
                $("#identificacion").val(data.identificacion);
                $("#nombre").val(data.name);
                $("#email").val(data.email);
                $("#telefono").val(data.telefono);
                $("#celular").val(data.celular);
                $("#direccion").val(data.direccion);
                $("#nacimiento").val(data.fecha_nacimiento);
                $("#expedicion").val(data.lugar_expedicion);
                $('#genero >option[value='+data.genero+']').attr('selected',true).trigger('change');
                $('#estado >option[value=' + data.estado + ']').attr('selected',true).trigger('change');
            }
        });
    });     
    $(document).on("click","#btn_update_users",function(){ 
        $('#form_updateUser').validate({            
            rules:{
                nombre:{ required:true },                    
            },          
            submitHandler: function(form){
                
                var id=$('#id_user').val();
                let formData = new FormData($('#form_updateUser')[0]);
                formData.append('id_user',id);
                $.ajax({
                    url:"/usuarios/update",
                    type:"POST",
                    data:formData,
                    processData: false,
                    contentType: false,
                    cache: false,
                    timeout: 600000,
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},                    
                   success:function(data){
                       if(data==1){
                        sweetMessage('\u00A1Registro exitoso!', '\u00A1 Se ha realizado con \u00E9xito su solicitud!');
                        setTimeout(function () { location.reload() }, 2000)
                       }
        
                   }
                });
         }

        });

    });
    $(document).on("click","#submit_users",function(e){                                
         $('#form_createUser').validate({            
            rules:{
                    identificacion:{ required:true },                    
                }, 
                  messages : {
                    identificacion: {
                        required: "Hey vamos, por favor, dános la identificacion"
                    }
            },            
            showErrors: function (errorMap, errorList) {
                var errors = this.numberOfInvalids();
                if (errorList.length>0) {
                var message = errors == 1
                ? 'La creacion de usuarios  tiene 1 error'
                : 'La creacion de usuarios tiene ' + errors + ' errores.';
                message = message + ' Por favor completa los campos requeridos .'
                sweetMessage('\u00A1Atenci\u00f3n!',message,'warning');
            } 
            this.defaultShowErrors();
            },submitHandler: function(form1){

                let dni=$('input[name="identificacion"]').val();
                let formData = new FormData($('#form_createUser')[0]);
                $.ajax({
                    url:"/usuarios/create",
                    type:"POST",
                    data:formData,
                    processData: false,
                    contentType: false,
                    cache: false,
                    timeout: 600000,
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},                    
                   success:function(data){
                       if(data==1){
                        sweetMessage('\u00A1Registro exitoso!', '\u00A1 Se ha realizado con \u00E9xito su solicitud!');
                        setTimeout(function(){ window.location.replace('/usuarios/inicio') },1000) ;   
                       }else{
                        sweetMessage('\u00A1Atenci\u00f3n!', 'El usuario con identificacion '+ dni +'  ya se encuentra registrado en la Base de datos. ', 'warning');
                       }
        
                   }
                });
         }
        });

    });


    $(document).on("click","#btn_pay_sales",function(e){                                

        let us=$('#id_usuario').val();
        let totalt=$('.payPending').html();
        Swal.fire({
            title: '¿ Esta Seguro ?',
            html: 'Deseas realizar el pago de los servicios prestados por valor  '+ totalt,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si'
          }).then((result) => {
            if (result.value) {

                
                $.ajax({
                    url:"/usuarios/pay_sales/",
                    data:{'id_usuario':us,'total':totalt},
                    type:"GET",
                    dataType:"JSON",
                    success:function(data){
                            if(data==1){
                                sweetMessage('\u00A1Registro exitoso!', '\u00A1 Se ha realizado con \u00E9xito su solicitud!');
                                setTimeout(function () { location.reload() }, 2000);

                            }

                    }
                });

              
                      
            }
          });

    });
    

   
    $(document).on("click","#btn_show_history",function(){          
        let id=$(this).attr('data-id');
        dt_pay_pending(id,2);
    });  


    $(document).on("click","#btn_show_payPending",function(){          
        let id=$(this).attr('data-id');
        dt_pay_pending(id,1);
    });  

    $('#form_checkin').on('submit', function(e) {
        e.preventDefault();
        var form = $(this);
        $.ajax({
            url: '/checkin-employe',
            type: 'POST',
            data: form.serialize(),
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function(response) {
                if(response.success){
                    $('#mdl_checkin').modal('hide');
                    location.reload();
                }
            }
        });
    });
});


var dt_teacher=function(){
    $('#dt_teacher').DataTable({        
          dom: 'Bfrtip',
          buttons: [
              'copy', 'csv', 'excel', 'pdf', 'print'
          ],      
        ajax: {
            url: "/dt_user",
            method: "GET", 
            dataSrc: function (json) {
                if (!json.data) {
                    return [];
                } else {
                    return json.data;
                }
              }               
            },
        columnDefs: [
            { width: '5%', targets: 0 },
            {"className": "text-center", "targets": "_all"},
            { orderable: true, className: 'reorder', targets: 0 },
            { orderable: true, className: 'reorder', targets: 6 },            
            { orderable: false, targets: '_all' }
        ],        
        columns: 
        [       
                { "data": "con" , render(data){return '<b>'+data+'</b>';}},         
                { "data": "dni" , render(data){return '<a class="text-primary">'+data+'</a>';}},
                { "data": "name",render(data,type,row){ return '<div class="text-info">'+  data +'</div>'; }},
                { "data": "celular"},
                { "data": "genero"},
                {"data": "cargo"},                 
                {"data": "estado", render(data){ let st=(data)? 'Activo':'Inactivo'; let color=(data)? 'success':'danger'; return  '<label class="badge text-white badge-'+color+' ">'+ st  +'</label>'; }},
                {"data": "", 
                    render(data,ps,d){ 
                        let button;
                        button='<div id="btn_show_user"  data-id='+d.id+'><i data-toggle="modal" data-target="#mdl_editUser" class="mdi mdi-pencil-box-outline text-primary" style="font-size:30px;"></i></div>';                        
                        return button; 
                    }
                },
        ]
    });
}
var dt_sales_user=function(){
    $('#dt_sales_user').DataTable({        
          dom: 'Bfrtip',
          buttons: ['csv', 'excel', 'pdf'],      
        ajax: {
            url: "/usuarios/dt_sales_user",
            method: "GET", 
            dataSrc: function (json) {                
                if (!json.data) {
                    return [];
                } else {
                    return json.data;
                }
              }               
            },
        columnDefs: [
            { width: '5%', targets: 0 },{"className": "text-center", "targets": "_all"},            
            { orderable: true, className: 'reorder', targets: 0 },
            { orderable: true, className: 'reorder', targets: 6 },           
            { orderable: false, targets: '_all' }
        ],       
        columns: 
        [       
                { "data": "con" , render(data){return '<p class="text-muted">'+data+'</p>';}},         
                { "data": "dni" , render(data){return '<b>'+data+'</b>';}},         
                { "data": "name",render(data,type,row){ return data; }},                
                {"data": "cant_servicios", render(data){  return  '<h4>'+ data +'</h4>'; }},
                {"data": "pagos", render(data){  return  '<h4><label class="badge text-white badge-success">'+ data +'</label></h4>'; }},            
                {"data": "pendiente", render(data){  
                    return  (data==0)? data:'<h4><label class="badge text-black badge-warning">'+ data +'</label></h4>';
                 }},
                {"data": "pend_pago", render(data){  return  '<h4> $ '+ data +'</h4>'; }},
                {"data": "", 
                    render(data,ps,d){ 
                        let button;
                        button='<i id="btn_show_history"  data-id='+d.id+' data-toggle="modal" data-target="#mdl_pay_history" class="mdi mdi-history text-info" style="font-size:30px;"></i>&nbsp;';                        
                        button+='<i id="btn_show_payPending"  data-id='+d.id+' data-toggle="modal" data-target="#mdl_paySales" class="mdi mdi-cash-multiple text-primary" style="font-size:30px;"></i>';                        
                        return button; 
                    }
                },
        ]
    });
}


var dt_pay_pending=function(id,status){
    
   var tdos= $('.dt_pay_pending').DataTable({
         "bDestroy": true,       
          dom: 'Bfrtip',
          buttons: ['excel','pdf'],      
        ajax: {
            url: "/usuarios/dt_pay_pending/"+id+"/"+status,
            method: "GET", 
            dataSrc: function (json) {
                $('.payPSales').html('$. ' + json.pay_sales);
                $('.payPending').html('$. ' + json.pay);
                $('#id_usuario').val(id);
                if (!json.data) {
                    return [];
                } else {
                    return json.data;
                }
              }               
            },
            columnDefs: [
                { width: '5%', targets: 0 },{"className": "text-center", "targets": "_all"},            
                { orderable: true, className: 'reorder', targets: 0 },                
                { orderable: false, targets: '_all' }
            ],     
        columns: 
        [   
                { "data": "no_venta" , render(data){return '<p class="text-muted">'+data+'</p>';}},                 
                { "data": "fecha_pago" , render(data){return '<b>'+data+'</b>';}},         
                { "data": "nombre_cliente" , render(data){return '<b>'+data+'</b>';}},                         
                { "data": "combo",render(data){ return data; }},  
                { "data": "vehiculo",render(data){ return data; }},                
                {"data": "precio_venta", render(data){  return  '<h4>$ '+ data +'</h4>'; }},
                {"data": "porcentaje", render(data){  return  '<h4><label class="badge text-white badge-success">'+ data +' % </label></h4>'; }},            
                {"data": "pago", render(data){  return  '<h4><label class="badge text-black badge-warning"> $ '+ data +'</label></h4>'; }},           
        ],        
    });    
}

$(document).on('click', '.btn_toggle_estado', function() {
    var id = $(this).data('id');
    var estado = $(this).data('estado');
    $.ajax({
        url: '/checkin-employe/estado',
        type: 'POST',
        data: {
            id: id,
            estado: estado,
            _token: $('input[name="_token"]').val()
        },
        success: function(response) {
            if(response.success){
                sweetMessage('¡Listo!', 'Estado actualizado correctamente');
                setTimeout(function(){ location.reload(); }, 1000);
            }
        }
    });
});