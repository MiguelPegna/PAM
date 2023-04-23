var tableMinutas;
document.addEventListener('DOMContentLoaded', function(){
    tableMinutas =$('#table-minutas').dataTable({
        'aProcessing' : true,
        'aServerSide': true,
        'language':{
            //'url': 'https://cdn.datatables.net/plug-ins/1.12.1/i18n/es-ES.json'
            'lengthMenu': 'Ver _MENU_ regs. por pag.',
            'info': 'página _PAGE_ de _PAGES_',
            'infoEmpty': 'No se encontraron resultados',
            'infoFiltered': '(filtrada de _MAX_ regs.',
            'loadingRecords': 'Cargando...',
            'processing': 'Procesando...',
            'search': '<span class="glyphicon glyphicon-search"></span> Buscar ',
            'zeroRecords': 'No se encontraron registros que coincidan con tu busqueda :(',
            'paginate': {
                'next': 'Sig.',
                'previous': 'Ant.'
            }
        },
        'ajax': {
            'url': ' '+base_url+'listaMin/getMinutas',
            'dataSrc': ''
        },
        //columnas de la tabla 
        'columns': [
            {'data':'titulo'},
            {'data':'unidad'},
            {'data':'fecha'}, 
            {'data':'estado'},
            {'data':'minuta_actions'}
        ],
        'resonsieve': 'true',
        'bDestroy': true,
        'iDisplayLength': 10,
        'order':[[0, 'desc']]
    }); 
});

$('#table-minutas').DataTable();

window.addEventListener('load', function(){
    fntDelMinuta();
    //fntLogos();
}, false);


//borrar Minuta
function fntDelMinuta(){
    var btnDropMin = document.querySelectorAll('.bDelMin');
    btnDropMin.forEach(function(btnDropMin){
        btnDropMin.addEventListener('click', function(){
            var idMin = this.getAttribute('rl');
            Swal.fire({
                width: '35%',
                reverseButtons: true,        
                heightAuto: true,
                footer: '<label class="barraTitle">Eliminar Minuta</label>',
                html: '<h5 class="acomodoText top-espacio">¿Deseas borrar esta Minuta? <br/>Al hacer esto la minuta ya no será visualizada.</h5>',
                showCancelButton: true,
                cancelButtonText: '<span class="glyphicon glyphicon-remove-sign"></span> Cancelar',
                confirmButtonText: '<span class="glyphicon glyphicon-ok-sign"></span> Aceptar',
                customClass: {
                    confirmButton: 'btn btn-primary espacio',
                    cancelButton: 'btn btn-default espacio'
                  },
                  buttonsStyling: false
            }).then((result) => {
                if(result.isConfirmed){
                    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                    var ajaxUrl = base_url+'listamin/delMinuta/';
                    var strData ='idMin='+idMin;
                    request.open("POST", ajaxUrl, true);
                    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                    request.send(strData);
                    request.onreadystatechange = function(){
                        if(request.readyState == 4 && request.status == 200){
                            var objData= JSON.parse(request.responseText);
                            if(objData.status){
                                Swal.fire({
                                    width: '35%',
                                    icon:'success',
                                    title: '<h3>Listo!</h3>',
                                    html: '<h4>'+objData.msg+'</h4>',
                                    confirmButtonColor: '#13322B',
                                    confirmButtonText: '<h5>Aceptar</h5>'
                                });
                                tableMinutas.api().ajax.reload(function(){
                                    fntDelMinuta();
                                    //fntLogos();
                                });
                                //alert('cuaja '+ajaxUrl+strData);
                            }
                            else{
                                Swal.fire({
                                    width: '35%',
                                    icon: 'error',
                                    title: '<h3>Oops...</h3>',
                                    html: `<h4>`+objData.msg+'</h4>',
                                    confirmButtonColor: '#13322B',
                                    confirmButtonText: '<h5>Aceptar</h5>'
                                });
                            }//end objSatus
                        }//end request
                    }
                }
            });//end then
        });
    });
}


//cargar los logos en combo deacuerdo al año
$(document).ready(function(){
    $("#AnhoLogo").change(function () { 
        $("#AnhoLogo option:selected").each(function () {
            id_anho= $(this).val();
            $.post(base_url+'getLogosMinuta', { id_anho: id_anho }, function(data){
                $("#logosMin").html(data);
            });            
        });
    });
});


//Cards PERMISOS Usuarios
$('.flip-card').on('click', 
  function(){
    $(this).toggleClass('flipped')
  }
);
