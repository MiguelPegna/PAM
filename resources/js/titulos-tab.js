var tableTitulos;
document.addEventListener('DOMContentLoaded', function(){
    tableTitulos =$('#table-titulos').dataTable({
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
            'url': ' '+base_url+'titulos/getTitulos',
            'dataSrc': ''
        },
        //columnas de la tabla 
        'columns': [
            {'data':'titulo_id'},
            {'data':'titulo_nom'}, 
            {'data':'titulo_abr'},
            {'data':'titulo_abr'},//va a cambiar a total de user con ee rol
            {'data':'titulo_actions'}
        ],
        'resonsieve': 'true',
        'bDestroy': true,
        'iDisplayLength': 10,
        'order':[[0, 'desc']]
    }); 

    //validacion del formulario y que el campo de rol no sea menor a 5 letras y mayor a 15
    var formTitulo = document.querySelector("#formTitulo");
    formTitulo.onsubmit = function(e) {
        e.preventDefault();
        //Declaracion de variables del formulario
        var intIdTitulo = document.querySelector('#idTitulo').value;  //Campo hidden almacena el id de rol
        var nomAbr= document.querySelector('#tAbr').value;   //caja de texto del rol
        var nomTitulo= document.querySelector('#tTitulo').value;   //caja de texto del rol

        var minimo =3;
        var limite = 20;
        if(nomTitulo== '' || nomTitulo.length < minimo || nomTitulo.length > limite ||nomAbr== '' || nomAbr.length < minimo || nomAbr.length >5){    
            Swal.fire({
                width: '35%',
                icon: 'error',
                title: '<h3>Oops...</h3>',
                html: '<h4>Nombre de Titulo no debe ser mayor a 20 letras y la Abreviación no mayor a 4 >:{</h4>',
                confirmButtonColor: '#13322B',
                confirmButtonText: '<h5>Aceptar</h5>'
            });
            return false;
        }
        //peticion Request para insertar rol a la DB
        //NUEVO TITULO
        var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        var ajaxUrl = base_url+'titulos/setTitulo';
        var formData = new FormData(formTitulo);

        request.open("POST",ajaxUrl,true);
        request.send(formData);
        request.onreadystatechange = function(){
            if(request.readyState == 4 && request.status == 200){
                var objData = JSON.parse(request.responseText);
                if(objData.status){
                    $('#titulo').modal('hide');
                    formTitulo.reset();
                    Swal.fire({
                        width: '35%',
                        icon:'success',
                        title: '<h3>Listo!</h3>',
                        html: '<h4>'+objData.msg+'</h4>',
                        confirmButtonColor: '#13322B',
                        confirmButtonText: '<h5>Aceptar</h5>'
                    });
                    tableTitulos.api().ajax.reload(function(){
                        fntEditTitulo();
                        fntDelTitulo();
                    });
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
                }
            }
        } // end request function
    }   //end function(e){
        
});

$('#table-titulos').DataTable();

function changeModal(){
    document.querySelector('#idTitulo').value='';
    document.querySelector('#titleModal').innerHTML='Agregar Nuevo Titulo Académico';
    document.querySelector('#actionTitulo').classList.replace('btn-info', 'btn-primary');
    document.querySelector('#txtBtn').innerHTML='Guardar';
    document.querySelector('#formTitulo').reset();
    $('#titulo').modal('hide');
}

window.addEventListener('load', function(){
    fntEditTitulo();
    fntDelTitulo();
}, false);

function fntEditTitulo(){
    var btnEditTitulo = document.querySelectorAll('.bEditTitulo');
    btnEditTitulo.forEach(function(btnEditTitulo){
        btnEditTitulo.addEventListener('click', function(){
            //$(".opStatus").show();
            //$(".formCargo").show();
            document.querySelector('#titleModal').innerHTML='Editar Titulo Académico';
            document.querySelector('#actionTitulo').classList.replace('btn-primary', 'btn-info');
            document.querySelector('#txtBtn').innerHTML='Actualizar';

            //mostrar la informacion del titulo por su idtitulo
            var idtitulo = this.getAttribute('rl');
            var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            var ajaxUrl = base_url+'titulos/getTitulo/'+idtitulo;
            request.open('GET', ajaxUrl, true);
            request.send();

            request.onreadystatechange = function(){
                if(request.readyState ==4 && request.status ==200){
                    var objData= JSON.parse(request.responseText);

                    if(objData.status){
                        document.querySelector('#idTitulo').value = objData.data.titulo_id;
                        document.querySelector('#tAbr').value = objData.data.titulo_abr;
                        document.querySelector('#tTitulo').value = objData.data.titulo_nom;

                    }
                    else{
                        Swal.fire(
                            'Oops...',
                            objData.msg,
                            'Error'
                        );
                    }
                }
            }
        });
    });
}
//borrar Titulo
function fntDelTitulo(){
    var btnDropTitulo = document.querySelectorAll('.bDelTitulo');
    btnDropTitulo.forEach(function(btnDropTitulo){
        btnDropTitulo.addEventListener('click', function(){
            var idtitulo = this.getAttribute('rl');
            Swal.fire({
                width: '35%',
                reverseButtons: true,        
                heightAuto: true,
                footer: '<label class="barraTitle">Eliminar Titulo Académico</label>',
                html: '<h5 class="acomodoText top-espacio">¿Deseas eliminar este Titulo? <br/>Si el titulo está en uso no se podrá eliminar.</h5>',
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
                    var ajaxUrl = base_url+'titulos/delTitulo/';
                    var strData ='idtitulo='+idtitulo;
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
                                tableTitulos.api().ajax.reload(function(){
                                    fntEditTitulo();
                                    fntDelTitulo();
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