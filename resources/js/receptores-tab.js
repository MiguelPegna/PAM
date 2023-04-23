var tableReceptores;
document.addEventListener('DOMContentLoaded', function(){
    tableReceptores =$('#table-receptores').dataTable({
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
            'url': ' '+base_url+'receptores/getReceptores',
            'dataSrc': ''
        },
        //columnas de la tabla 
        'columns': [
            {'data':'receptor_id'},
            {'data':'receptor_nom'}, 
            {'data':'receptor_id'},//va a cambiar a total de user con ee rol
            {'data':'receptor_tipo'},
            {'data':'receptor_actions'}
        ],
        'resonsieve': 'true',
        'bDestroy': true,
        'iDisplayLength': 10,
        'order':[[0, 'desc']]
    }); 

    //validacion del formulario y que el campo de rol no sea menor a 5 letras y mayor a 15
    var formReceptor = document.querySelector("#formReceptor");
    formReceptor.onsubmit = function(e) {
        e.preventDefault();
        //Declaracion de variables del formulario
        var intIdReceptor = document.querySelector('#idReceptor').value;  //Campo hidden almacena el id de rol
        var nomReceptor= document.querySelector('#tReceptor').value;   //caja de texto del rol
        var intStatus = document.querySelector('#listStatus').value;  //select q aparece al editar rol

        var minimo =10;
        //var limite = 100;
        if(nomReceptor== '' || nomReceptor.length < minimo || intStatus==''){    
            Swal.fire({
                width: '35%',
                icon: 'error',
                title: '<h3>Oops...</h3>',
                html: '<h4>El nombre de receptor debe ser mayor a 10 caracteres >:{</h4>',
                confirmButtonColor: '#13322B',
                confirmButtonText: '<h5>Aceptar</h5>'
            });
            return false;
        }
        //peticion Request para insertar rol a la DB
        //NUEVO receptor
        var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        var ajaxUrl = base_url+'receptores/setReceptor';
        var formData = new FormData(formReceptor);

        request.open("POST",ajaxUrl,true);
        request.send(formData);
        request.onreadystatechange = function(){
            if(request.readyState == 4 && request.status == 200){
                var objData = JSON.parse(request.responseText);
                if(objData.status){
                    $('#receptor').modal('hide');
                    formReceptor.reset();
                    Swal.fire({
                        width: '35%',
                        icon:'success',
                        title: '<h3>Listo!</h3>',
                        html: '<h4>'+objData.msg+'</h4>',
                        confirmButtonColor: '#13322B',
                        confirmButtonText: '<h5>Aceptar</h5>'
                    });
                    tableReceptores.api().ajax.reload(function(){
                        fntEditReceptor();
                        fntDelReceptor();
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

$('#table-receptores').DataTable();

function changeModal(){
    document.querySelector('#idReceptor').value='';
    document.querySelector('#titleModal').innerHTML='Agregar Nuevo Receptor';
    document.querySelector('#actionReceptor').classList.replace('btn-info', 'btn-primary');
    document.querySelector('#txtBtn').innerHTML='Guardar';
    document.querySelector('#formReceptor').reset();
    $('#receptor').modal('hide');
}

window.addEventListener('load', function(){
    fntEditReceptor();
    fntDelReceptor();
}, false);

function fntEditReceptor(){
    var btnEditReceptor = document.querySelectorAll('.bEditReceptor');
    btnEditReceptor.forEach(function(btnEditReceptor){
        btnEditReceptor.addEventListener('click', function(){
            //$(".opStatus").show();
            //$(".formReceptor").show();
            document.querySelector('#titleModal').innerHTML='Editar Receptor';
            document.querySelector('#actionReceptor').classList.replace('btn-primary', 'btn-info');
            document.querySelector('#txtBtn').innerHTML='Actualizar';

            //mostrar la informacion del rol por su idRol
            var idreceptor = this.getAttribute('rl');
            var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            var ajaxUrl = base_url+'receptores/getReceptor/'+idreceptor;
            request.open('GET', ajaxUrl, true);
            request.send();

            request.onreadystatechange = function(){
                if(request.readyState ==4 && request.status ==200){
                    var objData= JSON.parse(request.responseText);

                    if(objData.status){
                        document.querySelector("#idReceptor").value = objData.data.receptor_id;
                        document.querySelector('#tReceptor').value = objData.data.receptor_nom;

                        if(objData.data.receptor_tipo == 1){
                            var optionSelect = '<option value="1" selected class="opSelect">SI</option>';
                        }
                        else{
                            var optionSelect = '<option value="0" selected class="opSelect">NO</option>';
                        }
                        var htmlSelect = `${optionSelect}
                                          <option value="1">SI</option>
                                          <option value="0">NO</option>
                                        `;
                        document.querySelector("#listStatus").innerHTML = htmlSelect;
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
//borrar Receptor
function fntDelReceptor(){
    var btnDropReceptor = document.querySelectorAll('.bDelReceptor');
    btnDropReceptor.forEach(function(btnDropReceptor){
        btnDropReceptor.addEventListener('click', function(){
            var idreceptor = this.getAttribute('rl');
            Swal.fire({
                width: '35%',
                reverseButtons: true,        
                heightAuto: true,
                footer: '<label class="barraTitle">Eliminar Receptor</label>',
                html: '<h5 class="acomodoText top-espacio">¿Deseas eliminar este receptor? <br/>Si el receptor está en uso no se podrá eliminar.</h5>',
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
                    var ajaxUrl = base_url+'receptores/delReceptor/';
                    var strData ='idreceptor='+idreceptor;
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
                                tableRoles.api().ajax.reload(function(){
                                    fntEditReceptor();
                                    fntDelReceptor();
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