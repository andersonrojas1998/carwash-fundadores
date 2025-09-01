$(document).ready(function() {

  $('.DataTable').DataTable();
  $(document).on('click', '#btn_change_password', function() {
    window.location.href = '/change-password';
  });
  if(window.innerWidth < 768){

    if($('.btn-w-all').length){
      $('.btn-w-all').css('width','-webkit-fill-available');
    }

    $('.btn').addClass('btn-sm');
}

// Medida por defecto (Sin ningún nombre de clase)
else if(window.innerWidth < 900){
    $('.btn').removeClass('btn-sm');
}

// Si el ancho del navegador es menor a 1200 px le asigno la clase 'btn-lg' 
else if(window.innerWidth < 1200){
    $('.btn').addClass('btn-lg');
}



 $('#modal_edit_user_service').on('show.bs.modal', function () {
        if (isMobileOrTablet()) {
            $(this).find('.modal-dialog').css('width', '100%').css('max-width', '100%').css('margin', '0');
        } else {
            $(this).find('.modal-dialog').css('width', '').css('max-width', '').css('margin', '');
        }
    });


  $.extend($.fn.dataTable.defaults, {
		autoWidth : false,
		dom : '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
		language : {
			url : '/assets/js/spanish.json'
		},
	});
    $('.select2').select2();
    $('[data-toggle="tooltip"]').tooltip();

  if($('#sel_gradeStudents').length>0   || $('#sel_gradesPrint').length>0 ){
        $.ajax({ url:"/grades",type:"GET",success:function(data){
          let arr=JSON.parse(data);
          for(let i=0;i<arr.length;i++){                    
              $('#sel_gradeStudents').append('<option   value="'+arr[i].id_grado+'" >'+ firstLetter(arr[i].grupo.toLowerCase())  +'</option>');
              $('#sel_gradesPrint').append('<option   value="'+arr[i].id_grado+'" >'+ firstLetter(arr[i].grupo.toLowerCase())  +'</option>');
          }
          $('#sel_gradeStudents').select2();
          $('#sel_gradesPrint').select2();        
      }
      });
  }
    

    
});

function firstLetter(string){
    return string.charAt(0).toUpperCase() + string.slice(1);
}
function sel_option(url,id) {
    $(id).empty();
    $.ajax({ 
        url: url,
        type:"GET",success:function(data){
        let arr=JSON.parse(data);           
        $(id).append('<option value="">Seleccione</option>');
        for(let i=0;i<arr.length;i++){                            
            $(id).append('<option   value="'+arr[i].id+'" >'+ arr[i].name   +'</option>');
        }
        $(id).select2();
    }
    });
  }
var sweetMessage= function(title,msg,type='success'){
    swal.fire(title,msg,type);
}

/**
 * Muestra  mensaje de confirmacion con peticion al servidor ajax 
 * @param {Object} obj -  Object responsable  de retorno del sweetalert confirm
 * @param {string} obj.title  - title alert
 * @param {string} obj.text  - text alert
 * @param {string} obj.icon  - icon alert
 * @param {boolean} obj.ajax  -  true : false 
 * @param {boolean} obj.delRow  -  Elimina columna table
 * @param {boolean} obj.delfull  -  Elimina columna fullCalendar
 * @param {string} obj.calendarId  -Eliminar objecto del fullCalendar
 * @param {int} obj.reload  -   Recarga la pagina 1:0 
 * @param {string} obj.url  -  Url ajax
 * @param {string} obj.type  -  POST : GET 
 * @param {Object} obj.data  -  data Ajax
 */
 function sweetMessageConfirm(obj){
    Swal.fire({
        title: obj.title,
        html: obj.text,
        icon: obj.icon,
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si'
      }).then((result) => {
        if (result.value) {
          if(obj.ajax){          
            ajaxIon(obj);
          }else{
            sweetMessage('Eliminaci\u00F3n!', '\u00A1 Se ha realizado con \u00E9xito su solicitud!');
            (obj.delRow)?  $(obj.row).parents('tr').remove():'';
          }
                  
        }
      });
  }

  var ajaxIon= function(obj){
    $.ajax({ url:obj.url,type:obj.type,data:obj.data,dataType:"JSON",headers:{ 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success:function(result){
              if(result==1){
                sweetMessage('\u00A1Registro exitoso!', '\u00A1 Se ha realizado con \u00E9xito su solicitud!'); 
                (obj.reload!=0)?  setTimeout(function () { location.reload() }, 2000):'';                                                        
                (obj.delRow)?  $(obj.row).parents('tr').remove():'';
              }
              if(obj.delfull){              
                let calendarId=obj.calendarId;
                var event = calendarId.getEventById(result.idtable);              
                event.remove();
              }
                
  
            }
  
          });
  }

  var sweetMessageTimeOut=function(title,text,time=2000){
    let timerInterval
  Swal.fire({
    title: title,
    html: text,
    timer: time,
    timerProgressBar: true,
    onBeforeOpen: () => {
      Swal.showLoading()
      timerInterval = setInterval(() => {
        const content = Swal.getContent()
        if (content) {
          const b = content.querySelector('b')
          if (b) {
            b.textContent = Swal.getTimerLeft()
          }
        }
      }, 100)
    },
    onClose: () => {
      clearInterval(timerInterval)
    }
  }).then((result) => {
    /* Read more about handling dismissals below */
    if (result.dismiss === Swal.DismissReason.timer) {
     
    }
  })
  }
  var dt_qualificationsPeriod=function(grade,perid,teacher,course){
    $('#dt_qualificationsPeriod').DataTable({        
        lengthChange: false,        
        responsive: true,
        destroy: true,   
        searching:false, 
        "ordering": false,
        lengthMenu:false,
        paginate:false,
        ajax: {
            url: "/QualificationTable/",
            method: "GET", 
            data:{grade:grade,perid:perid,teacher:teacher,course:course},
            dataSrc: function (json) {
                if (!json.data) {
                    return [];
                } else {
                    return json.data;
                }
              }               
            },
        deferRender: true,            
        columnDefs: [{"className": "text-center", "targets": "_all"},],
        columns: 
        [
                { "data": "conc" , render(data){return '<b>'+data+'</b>';}},
                { "data": "mat" },                
                { "data": "alumn"},
                { "data": "grupo"},                                
                { "data": "period1"},
                { "data": "period2"},
                { "data": "period3"},                
        ],
        rowCallback:function(row,data,index){
            var p;
            switch (parseInt(perid)) {
                case 1:
                    p=data.period1;
                    break;
                    case 2:
                    p=data.period2;
                    break;
                    case 3:
                    p=data.period3;
                    break;
            }
            switch(true){                
                case (parseFloat(p)>'0.0' && parseFloat(p)<='2.9') :
                    $('td', row).css('background-color', 'rgba(255, 0, 0, 0.43)');
                break;
                case (parseFloat(p)>='3.0' && '3.9'>=parseFloat(p)):
                    $('td', row).css('background-color', 'rgba(255,153,51,0.43)');
                break;
                case (parseFloat(p)>='4.0' && '4.6'>=parseFloat(p)):
                    $('td', row).css('background-color', 'rgba(255,243,51,0.43)');
                break;
                case ('4.6' < parseFloat(p)):
                    $('td', row).css('background-color', 'rgba(53,193,4,0.43)');
                break;                
            }
            
        }
    });
}

// Detectar dispositivo móvil/tablet y ajustar el modal de pago
    function isMobileOrTablet() {
        return /android|webos|iphone|ipad|ipod|blackberry|iemobile|opera mini/i.test(navigator.userAgent.toLowerCase());
    }