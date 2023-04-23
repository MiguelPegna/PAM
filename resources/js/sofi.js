//funcion para validar formulario de la minuta 
document.addEventListener('DOMContentLoaded', function(){
    var formSOFI = document.querySelector("#formSOFI");
    formSOFI.onsubmit = function(e) {
        e.preventDefault();
        //definir variables del formulario
        var strDestinatario = document.querySelector('#destinatario').value;
        var strCargoDest = document.querySelector('#cargoDest').value;
        var strEmpDest = document.querySelector('#empDest').value;
        var strRemitente = document.querySelector('#remitente').value;
        var strCargoRem = document.querySelector('#cargoRem').value;
        var strEmpRem = document.querySelector('#empRem').value;
        var strFechaElab = document.querySelector('#fechaElaborado').value;
        var strFechaSict = document.querySelector('#fechaRecibidoSICT').value;
        var strAsunto = document.querySelector('#asunto').value;
        var strNumero = document.querySelector('#numero').value;
        var strDescripcion = document.querySelector('#descripcion').value;
       
        if(strDestinatario==''||strCargoDest== ''||strEmpDest== ''||strRemitente== ''||strCargoRem== ''||strEmpRem==''||strFechaElab==''||strFechaSict==''||strAsunto==''||strNumero==''||strDescripcion==''){
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
        
        //NUEVO oficio
        var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        var ajaxUrl = base_url+'sofi/setOficio';
        var formData = new FormData(formSOFI);

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
                    setTimeout(location.href='listaSofi',5000);
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

    //FORMULARIO DE DESTINATARIO
    var formDestinatario = document.querySelector("#formDestinatario");
    formDestinatario.onsubmit = function(e) {
        e.preventDefault();
        //Declaracion de variables del formulario
        var nombreD = document.querySelector('#nDestinatario').value; 
        var intTipoD = document.querySelector('#listStatus').value; 

        var minimoD =8;
        var limiteD = 30;
        if(nombreD== '' || nombreD.length < minimoD || nombreD.length > limiteD){    
            Swal.fire({
                width: '35%',
                icon: 'error',
                title: '<h3>Oops...</h3>',
                html: '<h4>Introduce el nombre completo del destinatario >:{</h4>',
                confirmButtonColor: '#13322B',
                confirmButtonText: '<h5>Aceptar</h5>'
            });
            return false;
        }
        //peticion Request para insertar destinatario a la DB
        //NUEVO DESTINATARIO
        var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        var ajaxUrl = base_url+'sofi/setDestinatario';
        var formData = new FormData(formDestinatario);

        request.open("POST",ajaxUrl,true);
        request.send(formData);
        request.onreadystatechange = function(){
            if(request.readyState == 4 && request.status == 200){
                var objData = JSON.parse(request.responseText);
                if(objData.status){
                    $('#SofiDestinatario').modal('hide');
                    formDestinatario.reset();
                    Swal.fire({
                        width: '35%',
                        icon:'success',
                        title: '<h3>Listo!</h3>',
                        html: '<h4>'+objData.msg+'</h4>',
                        confirmButtonColor: '#13322B',
                        confirmButtonText: '<h5>Aceptar</h5>'
                    });
                    //tableRoles.api().ajax.reload();
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



    //FORMULARIO DE REMITENTE
    var formRemitente = document.querySelector("#formRemitente");
    formRemitente.onsubmit = function(e) {
        e.preventDefault();
        //Declaracion de variables del formulario
        var nombreR = document.querySelector('#nRemitente').value; 
        var intTipoR = document.querySelector('#listStatus').value; 

        var minimoR =8;
        var limiteR = 30;
        if(nombreR== '' || nombreR.length < minimoR || nombreR.length > limiteR){    
            Swal.fire({
                width: '35%',
                icon: 'error',
                title: '<h3>Oops...</h3>',
                html: '<h4>Introduce el nombre completo del remitente >:{</h4>',
                confirmButtonColor: '#13322B',
                confirmButtonText: '<h5>Aceptar</h5>'
            });
            return false;
        }
        //peticion Request para insertar destinatario a la DB
        //NUEVO INVITADO
        var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        var ajaxUrl = base_url+'sofi/setRemitente';
        var formData = new FormData(formRemitente);

        request.open("POST",ajaxUrl,true);
        request.send(formData);
        request.onreadystatechange = function(){
            if(request.readyState == 4 && request.status == 200){
                var objData = JSON.parse(request.responseText);
                if(objData.status){
                    $('#SofiRemitente').modal('hide');
                    formRemitente.reset();
                    Swal.fire({
                        width: '35%',
                        icon:'success',
                        title: '<h3>Listo!</h3>',
                        html: '<h4>'+objData.msg+'</h4>',
                        confirmButtonColor: '#13322B',
                        confirmButtonText: '<h5>Aceptar</h5>'
                    });
                    //tableRoles.api().ajax.reload();
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


    //FORMULARIO DE CARGO
    var formCargo = document.querySelector("#formCargo");
    formCargo.onsubmit = function(e) {
        e.preventDefault();
        //Declaracion de variables del formulario
        var nombreC = document.querySelector('#tCargo').value; 
        var intTipoC = document.querySelector('#listStatus').value; 

        var minimoC =5;
        var limiteC = 30;
        if(nombreC== '' || nombreC.length < minimoC || nombreC.length > limiteC){    
            Swal.fire({
                width: '35%',
                icon: 'error',
                title: '<h3>Oops...</h3>',
                html: '<h4>Introduce un nombre valido de cargo >:{</h4>',
                confirmButtonColor: '#13322B',
                confirmButtonText: '<h5>Aceptar</h5>'
            });
            return false;
        }
        //peticion Request para insertar cargo a la DB
        //NUEVO INVITADO
        var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        var ajaxUrl = base_url+'sofi/setCargo';
        var formData = new FormData(formCargo);

        request.open("POST",ajaxUrl,true);
        request.send(formData);
        request.onreadystatechange = function(){
            if(request.readyState == 4 && request.status == 200){
                var objData = JSON.parse(request.responseText);
                if(objData.status){
                    $('#SofiCargo').modal('hide');
                    formCargo.reset();
                    Swal.fire({
                        width: '35%',
                        icon:'success',
                        title: '<h3>Listo!</h3>',
                        html: '<h4>'+objData.msg+'</h4>',
                        confirmButtonColor: '#13322B',
                        confirmButtonText: '<h5>Aceptar</h5>'
                    });
                    //tableRoles.api().ajax.reload();
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


    //FORMULARIO DE EMPRESA
    var formEmpresa = document.querySelector("#formEmpresa");
    formEmpresa.onsubmit = function(e) {
        e.preventDefault();
        //Declaracion de variables del formulario
        var nombreE = document.querySelector('#tEmpresa').value; 
        var intTipoE = document.querySelector('#listStatus').value; 

        var minimoE =8;
        var limiteE = 30;
        if(nombreE== '' || nombreE.length < minimoE || nombreE.length > limiteE){    
            Swal.fire({
                width: '35%',
                icon: 'error',
                title: '<h3>Oops...</h3>',
                html: '<h4>Introduce un nombre valido para la empresa >:{</h4>',
                confirmButtonColor: '#13322B',
                confirmButtonText: '<h5>Aceptar</h5>'
            });
            return false;
        }
        //peticion Request para insertar empresa a la DB
        //NUEVO INVITADO
        var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        var ajaxUrl = base_url+'sofi/setEmpresa';
        var formData = new FormData(formEmpresa);

        request.open("POST",ajaxUrl,true);
        request.send(formData);
        request.onreadystatechange = function(){
            if(request.readyState == 4 && request.status == 200){
                var objData = JSON.parse(request.responseText);
                if(objData.status){
                    $('#SofiEmpresa').modal('hide');
                    formEmpresa.reset();
                    Swal.fire({
                        width: '35%',
                        icon:'success',
                        title: '<h3>Listo!</h3>',
                        html: '<h4>'+objData.msg+'</h4>',
                        confirmButtonColor: '#13322B',
                        confirmButtonText: '<h5>Aceptar</h5>'
                    });
                    //tableRoles.api().ajax.reload();
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
        
    
}, false);

//cargamos las funciones que traeran los datos de la DB
window.addEventListener('load', function(){
    fntIdOfi();
}, false);


//funcion para obtener el ultimo id de minuta en la DB
function fntIdOfi(){
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    var ajaxUrl = base_url+'sofi/getIdOficio';
    request.open('GET', ajaxUrl, true);
    request.send();

    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            document.querySelector('#divId').innerHTML = request.responseText;

        }
    }
}



//buscadores
$(document).ready(function() {
    //buscador de destinatario
    $('#destinatario').on('keyup', function() {
        var destinatario = $(this).val();		
        var dataStringD = 'destinatario='+destinatario;
	    if(destinatario.length>0){
            $.ajax({
                type: "POST",
                url: base_url+'sofi/getDestinatario',
                data: dataStringD,
                success: function(data) {
                    //Escribimos las sugerencias que nos manda la consulta
                    $('#suggestions').fadeIn(500).html(data);
                    //Al hacer click en algua de las sugerencias
                    $('.destinatario').on('click', function(){
                            //Obtenemos la id unica de la sugerencia pulsada
                            var idD = $(this).attr('id');
                            //Editamos el valor del input con data de la sugerencia pulsada
                            $('#destinatario').val($('#'+idD).attr('data'));
                            //Hacemos desaparecer el resto de sugerencias
                            $('#suggestions').fadeOut(500);
                            //alert('Has seleccionado el '+id+' '+$('#'+id).attr('data'));
                            return false;
                    });
                }
            });
        }
        else{
            $('#suggestions').fadeOut(500);
        }
    });

    //buscador de cargo destinatario
    $('#cargoDest').on('keyup', function() {
        var cargoDest = $(this).val();		
        var dataStringCD = 'cargoDest='+cargoDest;
	    if(cargoDest.length>0){
            $.ajax({
                type: "POST",
                url: base_url+'sofi/getCargoDest',
                data: dataStringCD,
                success: function(data) {
                    //Escribimos las sugerencias que nos manda la consulta
                    $('#suggestionsCD').fadeIn(500).html(data);
                    //Al hacer click en algua de las sugerencias
                    $('.cargo-destinatario').on('click', function(){
                            //Obtenemos la id unica de la sugerencia pulsada
                            var idCD = $(this).attr('id');
                            //Editamos el valor del input con data de la sugerencia pulsada
                            $('#cargoDest').val($('#'+idCD).attr('data'));
                            //Hacemos desaparecer el resto de sugerencias
                            $('#suggestionsCD').fadeOut(500);
                            //alert('Has seleccionado el '+id+' '+$('#'+id).attr('data'));
                            return false;
                    });
                }
            });
        }
        else{
            $('#suggestionsCD').fadeOut(500);
        }
    });

    //buscador de empresa destinatario
    $('#empDest').on('keyup', function() {
        var empDest = $(this).val();		
        var dataStringED = 'empDest='+empDest;
	    if(empDest.length>0){
            $.ajax({
                type: "POST",
                url: base_url+'sofi/getEmpresaDest',
                data: dataStringED,
                success: function(data) {
                    //Escribimos las sugerencias que nos manda la consulta
                    $('#suggestionsED').fadeIn(500).html(data);
                    //Al hacer click en algua de las sugerencias
                    $('.empresa-destinatario').on('click', function(){
                            //Obtenemos la id unica de la sugerencia pulsada
                            var idEmpD = $(this).attr('id');
                            //Editamos el valor del input con data de la sugerencia pulsada
                            $('#empDest').val($('#'+idEmpD).attr('data'));
                            //Hacemos desaparecer el resto de sugerencias
                            $('#suggestionsED').fadeOut(500);
                            //alert('Has seleccionado el '+id+' '+$('#'+id).attr('data'));
                            return false;
                    });
                }
            });
        }
        else{
            $('#suggestionsED').fadeOut(500);
        }
    });

    //buscador de remitente
    $('#remitente').on('keyup', function() {
        var remitente = $(this).val();		
        var dataStringR = 'remitente='+remitente;
	    if(remitente.length>0){
            $.ajax({
                type: "POST",
                url: base_url+'sofi/getRemitente',
                data: dataStringR,
                success: function(data) {
                    //Escribimos las sugerencias que nos manda la consulta
                    $('#suggestionsR').fadeIn(500).html(data);
                    //Al hacer click en algua de las sugerencias
                    $('.remitente').on('click', function(){
                            //Obtenemos la id unica de la sugerencia pulsada
                            var idR = $(this).attr('id');
                            //Editamos el valor del input con data de la sugerencia pulsada
                            $('#remitente').val($('#'+idR).attr('data'));
                            //Hacemos desaparecer el resto de sugerencias
                            $('#suggestionsR').fadeOut(500);
                            //alert('Has seleccionado el '+id+' '+$('#'+id).attr('data'));
                            return false;
                    });
                }
            });
        }
        else{
            $('#suggestionsR').fadeOut(500);
        }
    });

    //buscador de cargo de remitente
    $('#cargoRem').on('keyup', function() {
        var cargoRem = $(this).val();		
        var dataStringCR = 'cargoRem='+cargoRem;
	    if(cargoRem.length>0){
            $.ajax({
                type: "POST",
                url: base_url+'sofi/getCargoRem',
                data: dataStringCR,
                success: function(data) {
                    //Escribimos las sugerencias que nos manda la consulta
                    $('#suggestionsCR').fadeIn(500).html(data);
                    //Al hacer click en algua de las sugerencias
                    $('.cargo-remitente').on('click', function(){
                            //Obtenemos la id unica de la sugerencia pulsada
                            var idCR = $(this).attr('id');
                            //Editamos el valor del input con data de la sugerencia pulsada
                            $('#cargoRem').val($('#'+idCR).attr('data'));
                            //Hacemos desaparecer el resto de sugerencias
                            $('#suggestionsCR').fadeOut(500);
                            //alert('Has seleccionado el '+id+' '+$('#'+id).attr('data'));
                            return false;
                    });
                }
            });
        }
        else{
            $('#suggestionsCR').fadeOut(500);
        }
    });

    //buscador de empresa de remitente
    $('#empRem').on('keyup', function() {
        var empRem = $(this).val();		
        var dataStringER = 'empRem='+empRem;
	    if(empRem.length>0){
            $.ajax({
                type: "POST",
                url: base_url+'sofi/getEmpresaRem',
                data: dataStringER,
                success: function(data) {
                    //Escribimos las sugerencias que nos manda la consulta
                    $('#suggestionsER').fadeIn(500).html(data);
                    //Al hacer click en algua de las sugerencias
                    $('.empresa-remitente').on('click', function(){
                            //Obtenemos la id unica de la sugerencia pulsada
                            var idEmpR = $(this).attr('id');
                            //Editamos el valor del input con data de la sugerencia pulsada
                            $('#empRem').val($('#'+idEmpR).attr('data'));
                            //Hacemos desaparecer el resto de sugerencias
                            $('#suggestionsER').fadeOut(500);
                            //alert('Has seleccionado el '+id+' '+$('#'+id).attr('data'));
                            return false;
                    });
                }
            });
        }
        else{
            $('#suggestionsER').fadeOut(500);
        }
    });
});

