var tableUsuarios;
document.addEventListener('DOMContentLoaded', function(){
    tableUsuarios =$('#table-usuarios').dataTable({
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
            'url': ' '+base_url+'usuarios/getUsers',
            'dataSrc': ''
        },
        //columnas de la tabla 
        'columns': [
            {'data':'user_id'},
            {'data':'info_user'},
            {'data':'info_sict'}, 
            {'data':'user_estado'},
            {'data':'user_actions'}
        ],
        'resonsieve': 'true',
        'bDestroy': true,
        'iDisplayLength': 10,
        'order':[[0, 'desc']]
    }); 

    //validacion del formulario y que el campo de User no sea menor a 5 letras y mayor a 15
    var formUser = document.querySelector("#formUser");
    formUser.onsubmit = function(e) {
        e.preventDefault();
        //Declaracion de variables del formulario
        var strNombre = document.querySelector('#tNombre').value;
        var strAp_p = document.querySelector('#tApe_p').value;
        var strAp_m = document.querySelector('#tApe_m').value;
        var strMail = document.querySelector('#tMail').value;

        var minimo =3;
        var limite = 15;
        if(strNombre== '' || strAp_p== '' || strAp_m== '' ||strMail==''){    
            Swal.fire({
                width: '35%',
                icon: 'error',
                title: '<h3>Oops...</h3>',
                html: '<h4>Todos los campos son obligatorios >:{</h4>',
                confirmButtonColor: '#13322B',
                confirmButtonText: '<h5>Aceptar</h5>'
            });
            return false;
        }

        let elementsValid = document.getElementsByClassName('.valid');
        for(let i=0; i<elementsValid.length; i++){
            if(elementsValid[i].classList.contains('.form-control-error')){
                Swal.fire({
                    width: '35%',
                    icon: 'error',
                    title: '<h3>Oops...</h3>',
                    html: '<h4>La información en los campos no es la aporpiada >:{</h4>',
                    confirmButtonColor: '#13322B',
                    confirmButtonText: '<h5>Aceptar</h5>'
                });
                return false;
            }
        }
        //peticion Request para insertar User a la DB
        //NUEVO User
        var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        var ajaxUrl = base_url+'usuarios/setUser';
        var formData = new FormData(formUser);

        request.open("POST",ajaxUrl,true);
        request.send(formData);
        request.onreadystatechange = function(){
            if(request.readyState == 4 && request.status == 200){
                var objData = JSON.parse(request.responseText);
                if(objData.status){
                    $('#usuario').modal('hide');
                    formUser.reset();
                    Swal.fire({
                        width: '35%',
                        icon:'success',
                        title: '<h3>Listo!</h3>',
                        html: '<h4>'+objData.msg+'</h4>',
                        confirmButtonColor: '#13322B',
                        confirmButtonText: '<h5>Aceptar</h5>'
                    });
                    tableUsuarios.api().ajax.reload(function(){
                        fntEditUser();
                        fntDelUser();
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

$('#table-usuarios').DataTable();

window.addEventListener('load', function(){
    fntEditUser();
    fntDelUser();
    fntUnidades();
    fntCargos();
    fntRoles();
    fntTitulos();
}, false);
//funcion para obtener las unidades de la DB
function fntUnidades(){
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    var ajaxUrl = base_url+'registro/getSelectUnidades';
    request.open('GET', ajaxUrl, true);
    request.send();

    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            document.querySelector('#unidadS').innerHTML = request.responseText;
            //document.querySelector('#unidadS').value = 1;
            //$('#unidadS').selectpicker('render');
        }
    }
}

//funcion para obtener los cargos de la DB
function fntCargos(){
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    var ajaxUrl = base_url+'cargos/getSelectCargos';
    request.open('GET', ajaxUrl, true);
    request.send();

    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            document.querySelector('#cargoS').innerHTML = request.responseText;
            //document.querySelector('#cargoS').value=1;
            //$('#cargoS').selectpicker('render');
        }
    }
}

//funcion para obtener las roles de la DB
function fntRoles(){
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    var ajaxUrl = base_url+'roles/getSelectRoles';
    request.open('GET', ajaxUrl, true);
    request.send();

    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            document.querySelector('#rolS').innerHTML = request.responseText;
            //document.querySelector('#rolS').value=1;
            //$('#rolS').selectpicker('render');
        }
    }
}
//funcion para obtener los titulos academicos de la DB
function fntTitulos(){
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    var ajaxUrl = base_url+'titulos/getSelectTitulos';
    request.open('GET', ajaxUrl, true);
    request.send();

    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            document.querySelector('#tituloS').innerHTML = request.responseText;
            //document.querySelector('#tituloS').value="";
            //$('#tituloS').selectpicker('render');
        }
    }
}
//funcion para editar la informacion de usuario
function fntEditUser(){
    var btnEditUser = document.querySelectorAll('.bEditUser');
    btnEditUser.forEach(function(btnEditUser){
        
        btnEditUser.addEventListener('click', function(){
            document.querySelector('#actionUser').classList.replace('btn-primary', 'btn-info');
            document.querySelector('#txtBtn').innerHTML='Actualizar';

            //mostrar la informacion del User por su idUser
            var iduser = this.getAttribute('rl');
            var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            var ajaxUrl = base_url+'usuarios/getUser/'+iduser;
            request.open('GET', ajaxUrl, true);
            request.send();

            request.onreadystatechange = function(){
                if(request.readyState ==4 && request.status ==200){
                    var objData= JSON.parse(request.responseText);

                    if(objData.status){
                        //inpu text
                        document.querySelector("#idUser").value = objData.data.user_id;
                        document.querySelector('#tNombre').value = objData.data.user_nom;
                        document.querySelector('#tApe_p').value = objData.data.user_ap;
                        document.querySelector('#tApe_m').value = objData.data.user_am;
                        document.querySelector('#tMail').value = objData.data.user_mail;
                        //selectpickers
                        document.querySelector('#unidadS').value = objData.data.user_unidad;
                        document.querySelector('#cargoS').value = objData.data.user_cargo;
                        document.querySelector('#rolS').value = objData.data.user_rol;
                        document.querySelector('#tituloS').value = objData.data.titulo_id;
                        //se renderiza el option del select con la opcion del usuario 
                        $('#unidadS').selectpicker('render');
                        $('#cargoS').selectpicker('render');
                        $('#rolS').selectpicker('render');
                        $('#tituloS').selectpicker('render');
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
//borrar User
function fntDelUser(){
    var btnDropUser = document.querySelectorAll('.bDelUser');
    btnDropUser.forEach(function(btnDropUser){
        btnDropUser.addEventListener('click', function(){
            var idUser = this.getAttribute('rl');
            Swal.fire({
                width: '35%',
                reverseButtons: true,        
                heightAuto: true,
                footer: '<label class="barraTitle">Eliminar Usuario</label>',
                html: '<h5 class="acomodoText top-espacio">¿Deseas inactivar a este usuario? <br/>Al hacer esto el usuario no podrá iniciar sesión.</h5>',
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
                    var ajaxUrl = base_url+'usuarios/delUser/';
                    var strData ='idUser='+idUser;
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
                                tableUsuarios.api().ajax.reload(function(){
                                    fntEditUser();
                                    fntDelUser();
                                    fntUnidades();
                                    fntCargos();
                                    fntRoles();
                                    fntTitulos();
                                    
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



//Cards PERMISOS Usuarios
$('.flip-card').on('click', 
  function(){
    $(this).toggleClass('flipped')
  }
);
