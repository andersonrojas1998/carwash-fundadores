$(function(){

    $('#table-service').DataTable(
        {
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],}
    );

    if($('#succes_message').length)
        sweetMessage('', $('#succes_message').val());

    if($('#fail_message').length)
        sweetMessage('', $('#fail_message').val(), 'error');
    
    $('.border-dark').css({'border': '1px solid #000000'});

    $('.card-service').css({'border-radius': '1em', 'overflow':'hidden'});
});