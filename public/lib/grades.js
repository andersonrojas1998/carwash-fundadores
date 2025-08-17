$(document).ready(function() {
    dt_grades();

    $(document).on("click","#show_create_grade , #btn_show_edit",function(){                 
        sel_option("/jornadaAll",".sel_jornadas");
        sel_option("/showTeacher",'.sel_teacher');
        sel_option("/nivelEducativoAll",'.sel_educativo');
    });
  });
  $(document).on("click","#btn_show_edit",function(){ 
    let id=$(this).attr('data-id');      
     $(".btn-update-grade").attr('data-id',id);
    $.ajax({
        url:"/grados/showEdit/"+id,
        type:"GET",
        dataType:"JSON",
        success:function(data) {            
            let d=data[0];           
            $("#nombre_edit").val(d.nombre);
            $("#grupo_edit").val(d.grupo);            
            $('#tag_edit').val(d.tag);
            $('#sel_jornadas_edit >option[value='+d.id_jornada+']').attr('selected',true).trigger('change');            
            $('#sel_teacher_edit >option[value='+d.idUser+']').attr('selected',true).trigger('change');
        }
    });
  });


  $(document).on("click","#btn_closeTime_period",function(){      
    let id=$(this).attr('data-id');
    Swal.fire({
        title: '\u00A1Atenci\u00f3n!',
        text: "Estas seguro que deseas Cerrar el periodo de Habilitacion !",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, Inactivar'
      }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '/periodos/closeTime/'+id,                    
                method: 'GET',
                dataType: "JSON",                    
            success: function(data){                          
                sweetMessage('\u00A1Registro exitoso!', '\u00A1 Se ha realizado con \u00E9xito su solicitud!');                  
                setTimeout(function () { location.reload() }, 2000);
             }
            });              
        }
      });


});
  $(document).on("click",".btn-update-grade",function(){ 
    let nombre=$("#nombre_edit").val();    
    let sel_jornadas=$("#sel_jornadas_edit").val();
    let tag=$("#tag_edit").val();
    let sel_teacher=$("#sel_teacher_edit").val(); 
     let grupo=$("#grupo_edit").val();  
    let id_grado=$(this).attr('data-id');

    if(nombre!="" && sel_jornadas!="" && tag!="" && sel_teacher!=""){
        $.ajax({
            url:"/grade/update",
            type:"POST",
            data:{nombre:nombre,id_jornada:sel_jornadas,tag:tag,id_docente:sel_teacher,grupo:grupo,id_grado:id_grado},
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success:function(data){
                if(data==1){
                    sweetMessage('\u00A1Registro exitoso!', '\u00A1 Se ha realizado con \u00E9xito su solicitud!');
                    setTimeout(function () { location.reload() }, 2000);
                   }else{
                    sweetMessage('\u00A1Atenci\u00f3n!', 'Error al actualizar el  grado. ', 'warning');
                   }
            }
        });        
    }

  });

  $(document).on("click",".btn-save-grade",function(){ 

    let nombre=$("#nombre").val();
    let grupo=$("#grupo").val();
    let sel_jornadas=$("#sel_jornadas").val();
    let tag=$("#tag").val();
    let sel_teacher=$("#sel_teacher").val();
    let educativo=$("#sel_educativo").val();
    if(nombre!="" && grupo!=""  && sel_jornadas!="" && tag!="" && sel_teacher!="" && educativo!=""){
        $.ajax({
            url:"/grade/created",
            type:"POST",
            data:{nombre:nombre,grupo:grupo,jornada:sel_jornadas,tag:tag,id_docente:sel_teacher,educativo:educativo},
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success:function(data){
                if(data==1){
                    sweetMessage('\u00A1Registro exitoso!', '\u00A1 Se ha realizado con \u00E9xito su solicitud!');
                    setTimeout(function () { location.reload() }, 2000);
                   }else{
                    sweetMessage('\u00A1Atenci\u00f3n!', 'El grado ingresado ya se encuentra registrado en la Base de datos. ', 'warning');
                   }
            }
        });        
    }
    
  });


  var dt_grades=function(){
    $('#dt_grades').DataTable({ 
        dom: 'Bfrtip',
    buttons: [
      'excel', 'pdf', 'print'
    ],
        responsive: true,
        ajax: {
            url: "/dt_grades",
            method: "GET", 
            dataSrc: function (json) {
                if (!json.data) {
                    return [];
                } else {
                    return json.data;
                }
              }               
            },      
        columnDefs: [{"className": "text-center", "targets": "_all"},],
        columns: 
        [
            { "data": "con" , render(data){return '<b>'+data+'</b>';}},
            { "data": "nombre" },
            { "data": "grupo",render(data,type,row){ return '<div class="text-info">'+  data +'</div>'; }},
            { "data": "jornada",render(data,type,row){ return '<div class="text-info">'+  data +'</div>'; }},
            { "data": "name",render(data,type,row){ return '<div class="text-capitalize">'+  data +'</div>'; }},
            { "data": "alumnos",render(data,type,row){ return '<span class="badge badge-success text-white">'+  data +'</span>'; }},
            { "data": "actions",render(data,type,row){ 
                return '<i  id="btn_show_edit" data-id='+row.id+' data-toggle="modal" data-target="#mdl_edit_grades" class=" icon-md mdi mdi-pencil-box-outline text-primary"></i>'+
                '<i class=""></i>'
                
            }}
        ]
    });
  }