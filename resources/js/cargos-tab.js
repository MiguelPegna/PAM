var tableCargos;
document.addEventListener('DOMContentLoaded', function(){
    tableCargos =$('#table-cargos').dataTable({
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
            'url': ' '+base_url+'cargos/getCargos',
            'dataSrc': ''
        },
        //columnas de la tabla 
        'columns': [
            {'data':'cargo_id'},
            {'data':'cargo_nom'}, 
            {'data':'cargo_id'},//va a cambiar a total de user con ee rol
            {'data':'cargo_tipo'},
            {'data':'cargo_actions'}
        ],
        'resonsieve': 'true',
        'bDestroy': true,
        'iDisplayLength': 10,
        'order':[[0, 'desc']]
    }); 

    //validacion del formulario y que el campo de rol no sea menor a 5 letras y mayor a 15
    var formCargo = document.querySelector("#formCargo");
    formCargo.onsubmit = function(e) {
        e.preventDefault();
        //Declaracion de variables del formulario
        var intIdCargo = document.querySelector('#idCargo').value;  //Campo hidden almacena el id de rol
        var nomCargo= document.querySelector('#tCargo').value;   //caja de texto del rol
        var intStatus = document.querySelector('#listStatus').value;  //select q aparece al editar rol

        var minimo =10;
        //var limite = 100;
        if(nomCargo== '' || nomCargo.length < minimo || intStatus==''){    
            Swal.fire({
                width: '35%',
                icon: 'error',
                title: '<h3>Oops...</h3>',
                html: '<h4>El nombre de cargo debe ser mayor a 10 caracteres >:{</h4>',
                confirmButtonColor: '#13322B',
                confirmButtonText: '<h5>Aceptar</h5>'
            });
            return false;
        }
        //peticion Request para insertar rol a la DB
        //NUEVO cargo
        var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        var ajaxUrl = base_url+'cargos/setCargo';
        var formData = new FormData(formCargo);

        request.open("POST",ajaxUrl,true);
        request.send(formData);
        request.onreadystatechange = function(){
            if(request.readyState == 4 && request.status == 200){
                var objData = JSON.parse(request.responseText);
                if(objData.status){
                    $('#cargo').modal('hide');
                    formCargo.reset();
                    Swal.fire({
                        width: '35%',
                        icon:'success',
                        title: '<h3>Listo!</h3>',
                        html: '<h4>'+objData.msg+'</h4>',
                        confirmButtonColor: '#13322B',
                        confirmButtonText: '<h5>Aceptar</h5>'
                    });
                    tableCargos.api().ajax.reload(function(){
                        fntEditCargo();
                        fntDelCargo();
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

$('#table-cargos').DataTable();

function changeModal(){
    document.querySelector('#idCargo').value='';
    document.querySelector('#titleModal').innerHTML='Agregar Nuevo Cargo';
    document.querySelector('#actionCargo').classList.replace('btn-info', 'btn-primary');
    document.querySelector('#txtBtn').innerHTML='Guardar';
    document.querySelector('#formCargo').reset();
    $('#cargo').modal('hide');
}

window.addEventListener('load', function(){
    fntEditCargo();
    fntDelCargo();
}, false);

function fntEditCargo(){
    var btnEditCargo = document.querySelectorAll('.bEditCargo');
    btnEditCargo.forEach(function(btnEditCargo){
        btnEditCargo.addEventListener('click', function(){
            //$(".opStatus").show();
            //$(".formCargo").show();
            document.querySelector('#titleModal').innerHTML='Editar Cargo';
            document.querySelector('#actionCargo').classList.replace('btn-primary', 'btn-info');
            document.querySelector('#txtBtn').innerHTML='Actualizar';

            //mostrar la informacion del rol por su idRol
            var idcargo = this.getAttribute('rl');
            var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            var ajaxUrl = base_url+'cargos/getCargo/'+idcargo;
            request.open('GET', ajaxUrl, true);
            request.send();

            request.onreadystatechange = function(){
                if(request.readyState ==4 && request.status ==200){
                    var objData= JSON.parse(request.responseText);

                    if(objData.status){
                        document.querySelector("#idCargo").value = objData.data.cargo_id;
                        document.querySelector('#tCargo').value = objData.data.cargo_nom;

                        if(objData.data.cargo_tipo == 1){
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
//borrar Cargo
function fntDelCargo(){
    var btnDropCargo = document.querySelectorAll('.bDelCargo');
    btnDropCargo.forEach(function(btnDropCargo){
        btnDropCargo.addEventListener('click', function(){
            var idcargo = this.getAttribute('rl');
            Swal.fire({
                width: '35%',
                reverseButtons: true,        
                heightAuto: true,
                footer: '<label class="barraTitle">Eliminar Cargo</label>',
                html: '<h5 class="acomodoText top-espacio">¿Deseas eliminar este cargo? <br/>Si el cargo está en uso no se podrá eliminar.</h5>',
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
                    var ajaxUrl = base_url+'cargos/delCargo/';
                    var strData ='idcargo='+idcargo;
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
                                    fntEditCargo();
                                    fntDelCargo();
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