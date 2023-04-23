var tableRoles;
document.addEventListener('DOMContentLoaded', function(){
    tableRoles =$('#table-roles').dataTable({
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
            'url': ' '+base_url+'roles/getRoles',
            'dataSrc': ''
        },
        //columnas de la tabla 
        'columns': [
            {'data':'rol_id'},
            {'data':'rol_nombre'},
            {'data':'rol_nombre'}, //va a cambiar a total de user con ee rol
            {'data':'rol_estado'},
            {'data':'rol_actions'}
        ],
        'resonsieve': 'true',
        'bDestroy': true,
        'iDisplayLength': 10,
        'order':[[0, 'desc']]
    }); 

    //validacion del formulario y que el campo de rol no sea menor a 5 letras y mayor a 15
    var formRol = document.querySelector("#formRol");
    formRol.onsubmit = function(e) {
        e.preventDefault();
        //Declaracion de variables del formulario
        var intIdRol = document.querySelector('#idRol').value;  //Campo hidden almacena el id de rol
        var nomRol= document.querySelector('#tRol').value;   //caja de texto del rol
        var intStatus = document.querySelector('#listStatus').value;  //select q aparece al editar rol

        var minimo =3;
        var limite = 15;
        if(nomRol== '' || nomRol.length < minimo || nomRol.length > limite || intStatus==''){    
            Swal.fire({
                width: '35%',
                icon: 'error',
                title: '<h3>Oops...</h3>',
                html: '<h4>El nombre de Rol debe ser mayor a 3 letras y menor a 15 >:{</h4>',
                confirmButtonColor: '#13322B',
                confirmButtonText: '<h5>Aceptar</h5>'
            });
            return false;
        }
        //peticion Request para insertar rol a la DB
        //NUEVO ROL
        var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        var ajaxUrl = base_url+'roles/setRol';
        var formData = new FormData(formRol);

        request.open("POST",ajaxUrl,true);
        request.send(formData);
        request.onreadystatechange = function(){
            if(request.readyState == 4 && request.status == 200){
                var objData = JSON.parse(request.responseText);
                if(objData.status){
                    $('#rol').modal('hide');
                    formRol.reset();
                    Swal.fire({
                        width: '35%',
                        icon:'success',
                        title: '<h3>Listo!</h3>',
                        html: '<h4>'+objData.msg+'</h4>',
                        confirmButtonColor: '#13322B',
                        confirmButtonText: '<h5>Aceptar</h5>'
                    });
                    tableRoles.api().ajax.reload(function(){
                        fntEditRol();
                        fntDelRol();
                        fntPermisos();
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

$('#table-roles').DataTable();

function changeModal(){
    $(".opStatus").hide();
    document.querySelector('#idRol').value='';
    document.querySelector('#titleModal').innerHTML='Agregar Nuevo Rol';
    document.querySelector('#actionRol').classList.replace('btn-info', 'btn-primary');
    document.querySelector('#txtBtn').innerHTML='Guardar';
    document.querySelector('#formRol').reset();
    $('#rol').modal('hide');
}

window.addEventListener('load', function(){
    fntEditRol();
    fntDelRol();
    fntPermisos();
}, false);

function fntEditRol(){
    var btnEditRol = document.querySelectorAll('.bEditRol');
    btnEditRol.forEach(function(btnEditRol){
        btnEditRol.addEventListener('click', function(){
            
            $(".opStatus").show();
            $(".formRol").show();
            document.querySelector('#titleModal').innerHTML='Editar Rol';
            document.querySelector('#actionRol').classList.replace('btn-primary', 'btn-info');
            document.querySelector('#txtBtn').innerHTML='Actualizar';

            //mostrar la informacion del rol por su idRol
            var idrol = this.getAttribute('rl');
            var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            var ajaxUrl = base_url+'roles/getRol/'+idrol;
            request.open('GET', ajaxUrl, true);
            request.send();

            request.onreadystatechange = function(){
                if(request.readyState ==4 && request.status ==200){
                    var objData= JSON.parse(request.responseText);

                    if(objData.status){
                        document.querySelector("#idRol").value = objData.data.rol_id;
                        document.querySelector('#tRol').value = objData.data.rol_nombre;

                        if(objData.data.rol_estado == 1){
                            var optionSelect = '<option value="1" selected class="opSelect">Activo</option>';
                        }
                        else{
                            var optionSelect = '<option value="0" selected class="opSelect">Inactivo</option>';
                        }
                        var htmlSelect = `${optionSelect}
                                          <option value="1">Activo</option>
                                          <option value="0">Inactivo</option>
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
//borrar rol
function fntDelRol(){
    var btnDropRol = document.querySelectorAll('.bDelRol');
    btnDropRol.forEach(function(btnDropRol){
        btnDropRol.addEventListener('click', function(){
            var idrol = this.getAttribute('rl');
            Swal.fire({
                width: '35%',
                reverseButtons: true,        
                heightAuto: true,
                footer: '<label class="barraTitle">Eliminar Rol</label>',
                html: '<h5 class="acomodoText top-espacio">¿Deseas desactivar este rol de usuario? <br/>Al hacer esto los usuarios con este rol pasaran a ser usuarios inactivos.</h5>',
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
                    var ajaxUrl = base_url+'roles/delRol/';
                    var strData ='idrol='+idrol;
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
                                    fntEditRol();
                                    fntDelRol();
                                    fntPermisos();
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

//FUNCION DE PERMISOS
function fntPermisos(){
    var btnKeyRol = document.querySelectorAll('.bKeyRol');
    btnKeyRol .forEach(function(btnKeyRol){
        btnKeyRol.addEventListener('click', function(){
            //$('#rolPermisos').modal('show');
            var idrol = this.getAttribute('rl');
            var request =(window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            var ajaxUrl = base_url+'permisos/getPermisosRol/'+idrol;
            request.open('GET', ajaxUrl, true);
            request.send();
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    document.querySelector('#contentAjax').innerHTML = request.responseText;
                    $('#rolPermisos').modal('show');
                    //envio de formulario
                    document.querySelector('#permisoFormRol').addEventListener('submit', fntSavePermisos, false);

                }
            }
        });
    });
}

function fntSavePermisos(e){
    e.preventDefault();
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    var ajaxUrl = base_url+'permisos/setPermisos'; 
    var formElement = document.querySelector("#permisoFormRol");
    var formData = new FormData(formElement);
    request.open('POST',ajaxUrl,true);
    request.send(formData);

    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            var objData= JSON.parse(request.responseText);
            if(objData.status){
                $('#rolPermisos').modal('hide');
                Swal.fire({
                    width: '35%',
                    icon:'success',
                    title: '<h3>Listo!</h3>',
                    html: '<h4>'+objData.msg+'</h4>',
                    confirmButtonColor: '#13322B',
                    confirmButtonText: '<h5>Aceptar</h5>'
                });
            }else{
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
    }
    
}

//Cards PERMISOS ROLES
$('.flip-card').on('click', 
  function(){
    $(this).toggleClass('flipped')
  }
);
