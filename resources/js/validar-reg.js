//funcion para validar formulario
document.addEventListener('DOMContentLoaded', function(){
    var formRegistro = document.querySelector("#formRegistro");
    formRegistro.onsubmit = function(e) {
        e.preventDefault();
        //definir variables del formulario
        var strNombre = document.querySelector('#nombre').value;
        var strAp_p = document.querySelector('#apP').value;
        var strAp_m = document.querySelector('#apM').value;
        //var intUnidad = document.querySelector('#unidadS').value;
        //var intCargo = document.querySelector('#cargoS').value;
        //var intRol = document.querySelector('#rolS').value;
        //var intTitulo = document.querySelector('#tituloS').value;
        var strMail = document.querySelector('#email').value;
        var strPass01 = document.querySelector('#pass01').value;
        var strPass02 = document.querySelector('#pass02').value;

        if(strNombre== '' || strAp_p== '' || strAp_m== '' ||strMail=='' ||strPass01==''||strPass02==''){    
            Swal.fire({
                width: '35%',
                icon: 'error',
                title: '<h3>Oops...</h3>',
                html: '<h4>Todos los campos son obligatorios >:{</h4>',
                confirmButtonColor: '#13322B',
                confirmButtonText: '<h5>Aceptar</h5>'
            });
        }
        else if(strPass01 != strPass02) {
            Swal.fire({
                width: '35%',
                icon: 'error',
                title: '<h3>Oops...</h3>',
                html: '<h4>Las contraseñas no coinciden >:{</h4>',
                confirmButtonColor: '#13322B',
                confirmButtonText: '<h5>Aceptar</h5>'
            });
            return false;
        }
        
        //NUEVO Usuario
        var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        var ajaxUrl = base_url+'registro/setRegistro';
        var formData = new FormData(formRegistro);

        request.open("POST",ajaxUrl,true);
        request.send(formData);
        request.onreadystatechange = function(){
            if(request.readyState == 4 && request.status == 200){
                var objData = JSON.parse(request.responseText);
                if(objData.status){
                    Swal.fire({
                        width: '35%',
                        icon:'success',
                        title: '<h3>Listo!</h3>',
                        html: '<h4>'+objData.msg+'</h4>',
                        confirmButtonColor: '#13322B',
                        confirmButtonText: '<h5>Aceptar</h5>'
                    });
                    //redireccion a lista usuarios cuando se haga registro
                    setTimeout(location.href='usuarios',3000);
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
    }
}, false);

//cargamos las funciones que traeran los datos de la DB
window.addEventListener('load', function(){
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
            document.querySelector('#unidadS').value=1;
            $('#unidadS').selectpicker('render');
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
            document.querySelector('#cargoS').value=1;
            $('#cargoS').selectpicker('render');
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
            document.querySelector('#rolS').value=1;
            $('#rolS').selectpicker('render');
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
            document.querySelector('#tituloS').value="";
            $('#tituloS').selectpicker('render');
        }
    }
}