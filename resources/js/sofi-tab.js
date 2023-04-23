var tableOficios;
document.addEventListener('DOMContentLoaded', function(){
    tableOficios =$('#table-oficios').dataTable({
        'language':{
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
                'previous': 'Ant.',
                
            },
        },
        'resonsieve': 'true',
        'bDestroy': true,
        'iDisplayLength': 10
    }); 
  
});

$('#table-oficios').DataTable();

window.addEventListener('load', function(){
    //fntEditRep();
    //fntDelRep();
    fntOficios(); //carga los oficios

}, false);

//funcion para obtener las unidades de la DB
function fntOficios(){
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    var ajaxUrl = base_url+'listaSofi/getOficios';
    request.open('GET', ajaxUrl, true);
    request.send();

    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            document.querySelector('#registros').innerHTML = request.responseText;
        }
    }
}


//funcion para editar la informacion de usuario
function fntEditRep(){
    var btnEditRep = document.querySelectorAll('.bEditRep');
    btnEditRep.forEach(function(btnEditRep){
        btnEditRep.addEventListener('click', function(){
            //mostrar la informacion del User por su idUser
            var idReporte = this.getAttribute('rl');
            var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            var ajaxUrl = base_url+'editarRep/getReporte/'+idReporte;
            request.open('GET', ajaxUrl, true);
            request.send();
        });
    });
}

//borrar Oficio
function fntDelRep(){
    var btnDropOficio = document.querySelectorAll('.bDelOficio');
    btnDropOficio.forEach(function(btnDropOficio){
        btnDropOficio.addEventListener('click', function(){
            var idOficio = this.getAttribute('rl');
            Swal.fire({
                width: '35%',
                reverseButtons: true,        
                heightAuto: true,
                footer: '<label class="barraTitle">Eliminar Oficio</label>',
                html: '<h5 class="acomodoText top-espacio">¿Deseas inactivar a este oficio? <br/>Al hacer esto el oficio no será visible.</h5>',
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
                    var ajaxUrl = base_url+'usuarios/delOficio/';
                    var strData ='idOficio='+idOficio;
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
                                tableOficios.api().ajax.reload(function(){
                                    fntEditRep();
                                    fntDelRep();
                                    
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