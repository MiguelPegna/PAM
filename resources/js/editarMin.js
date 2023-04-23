//funcion para validar formulario de la minuta 
document.addEventListener('DOMContentLoaded', function(){
    var formMinuta = document.querySelector("#formMinuta");
    formMinuta.onsubmit = function(e) {
        e.preventDefault();
        //definir variables del formulario
        var strFechaMin = document.querySelector('#fechaMin').value;
        var strHora = document.querySelector('#hora').value;
        var strHoraC = document.querySelector('#horaC').value;
        var strLugar = document.querySelector('#lugar').value;
        var strTituloMin = document.querySelector('#tituloMin').value;
        var strObservacion = document.querySelector('#observacion').value;
        var strTituloA = document.querySelector('.tituloA').value;
        var strFechaA = document.querySelector('.fechaA').value;
        var strResponsableA = document.querySelector('.responsable').value;


        if(strFechaMin== '' || strHora== '' || strHoraC== '' || strLugar== '' ||strTituloMin=='' ||strObservacion==''||strTituloA==''||strFechaA==''||strResponsableA==''){    
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
        
        //Actualizamos minuta
        var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        var ajaxUrl = base_url+'editarMin/setMinuta';
        var formData = new FormData(formMinuta);

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
                    setTimeout(location.href='listamin',5000);
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

    //FORMULARIO DE INVITADO
    var formInvitado = document.querySelector("#formInvitado");
    formInvitado.onsubmit = function(e) {
        e.preventDefault();
        //Declaracion de variables del formulario
        var nombre = document.querySelector('#tNombre').value; 
        var intTipo = document.querySelector('#listStatus').value; 
        var titulo= document.querySelector('#tituloS').value;   //caja de texto del titulo
        var mail= document.querySelector('#tMail').value;   //caja de texto del titulo
        var cargo= document.querySelector('#cargoI').value;   //caja de texto del rol

        var minimo =8;
        var limite = 30;
        if(nombre== '' || nombre.length < minimo || nombre.length > limite){    
            Swal.fire({
                width: '35%',
                icon: 'error',
                title: '<h3>Oops...</h3>',
                html: '<h4>Introduce el nombre completo del invitado >:{</h4>',
                confirmButtonColor: '#13322B',
                confirmButtonText: '<h5>Aceptar</h5>'
            });
        }
        else if(mail=='') {
            Swal.fire({
                width: '35%',
                icon: 'error',
                title: '<h3>Oops...</h3>',
                html: '<h4>Introduce una dirección de correo >:{</h4>',
                confirmButtonColor: '#13322B',
                confirmButtonText: '<h5>Aceptar</h5>'
            });
            return false;
        }
        //peticion Request para insertar rol a la DB
        //NUEVO INVITADO
        var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        var ajaxUrl = base_url+'minutas/setInvitado';
        var formData = new FormData(formInvitado);

        request.open("POST",ajaxUrl,true);
        request.send(formData);
        request.onreadystatechange = function(){
            if(request.readyState == 4 && request.status == 200){
                var objData = JSON.parse(request.responseText);
                if(objData.status){
                    $('#invitado').modal('hide');
                    formInvitado.reset();
                    Swal.fire({
                        width: '35%',
                        icon:'success',
                        title: '<h3>Listo!</h3>',
                        html: '<h4>'+objData.msg+'</h4>',
                        confirmButtonColor: '#13322B',
                        confirmButtonText: '<h5>Aceptar</h5>'
                    });
                    var participantes;
                    participantes =$('#userS');
                    participantes.api().ajax.reload(function(){
                        //fntCargos();
                        fntParticipantes();
                        //fntIdMin();
                        //fntTitulos();
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
        
    
}, false);

//cargamos las funciones que traeran los datos de la DB
window.addEventListener('load', function(){
    fntCargos();
    fntParticipantes();
    fntTitulos();
    fntMin();
}, false);

function fntMin(){
    var idMinuta = document.querySelector('#idMinuta').value;
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    var ajaxUrl = base_url+'editarMin/getMinuta/'+idMinuta;
    request.open('GET', ajaxUrl, true);
    request.send();
    
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            var objData= JSON.parse(request.responseText);

            if(objData.status){
                document.querySelector('#fechaMin').value= objData.data.fecha;
                document.querySelector('#hora').value= objData.data.hora;
                document.querySelector('#horaC').value= objData.data.horaCierre;
                document.querySelector('#lugar').value= objData.data.lugar;
                document.querySelector('#tituloMin').value= objData.data.titulo;
                document.querySelector('#cargoS').options= objData.data.unidad;
                document.querySelector('#observacion').value= objData.data.desarrollo;
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

            document.querySelector('#cargoI').innerHTML = request.responseText;
            document.querySelector('#cargoI').value=1;
            $('#cargoI').selectpicker('render');
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

//funcion para obtener los usuarios de la DB
function fntParticipantes(){
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    var ajaxUrl = base_url+'editarMin/getSelectParticipantes';
    request.open('GET', ajaxUrl, true);
    request.send();

    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            document.querySelector('#userS').innerHTML = request.responseText;
            document.querySelector('#userS').value=1;
            $('#userS').selectpicker('render');
        }
    }
}


$().ready(function(){
	$('#addP').click(function() {
        return !($('#userS option:selected').clone()).appendTo('.responsable');
	});


    /*
    $('.responsable').change(function(){
        var op = $(this).val();
        if (this.value == op){
            $('.responsable option[value='+op+']').remove();
            return !($('#userS option:selected').clone()).appendTo('.responsable'); 
        }
    });
    */
    
	$('.quitar').click(function() { 
		return !$('.responsable option:selected').remove().appendTo('#userS');
	});
		 
	$('.quitartodos').click(function() { $('.responsable option').each(function() { $(this).remove().appendTo('#userS'); }); });
	//$('.submit').click(function() { $('#destino option').prop('selected', 'selected'); });
});


//funcion de agregar acuerdo
let acuerdos=1;
    let numTit=1;
    let numDate=1;
    let numResp=1;

function addRow(tableID) {
    
    if (acuerdos<50) {
        
        let table = document.getElementById(tableID);
        
        let rowCount = table.rows.length;
        let row = table.insertRow(rowCount);

        let cell1 = row.insertCell(0);
        let element1 = document.createElement("input");
        cell1.className = "form-control";
        element1.type = "checkbox";
        element1.name="chkbox[]";
        element1.className="check";
        acuerdos++;
        cell1.appendChild(element1);
        
        let cell2 = row.insertCell(1); 
        let element2 = document.createElement("input");
        cell2.className="col-md-6 td-a";
        element2.type = "text";
        element2.setAttribute("id", "tituloA[]");
        element2.name = "tituloA[]";
        element2.className = "form-control";
        numTit++;
        element2.value = acuerdos;
        cell2.appendChild(element2);

        let cell3 = row.insertCell(2); 
        let element3 = document.createElement("input");
        cell3.className="col-md-2 td-a";
        element3.type = "date";
        element3.setAttribute("id", "fechaA[]");
        element3.name = "fechaA[]";
        element3.className = "form-control";
        numDate++;
        cell3.appendChild(element3);

        let cell4 = row.insertCell(3); 
        let element4 = document.createElement("select");
        cell4.className="col-md-4 td-a ";
        element4.setAttribute("id", "responsable[]");
        element4.setAttribute("data-live-search", "true");
        element4.name = "responsable[]";
        element4.className = "form-control responsable i-format";

        numResp++;      
        cell4.appendChild(element4);

    }
}

function deleteRow(tableID) {
    try {
    let table = document.getElementById(tableID);
    let rowCount = table.rows.length;

    for(let i=0; i<rowCount; i++) {
        let row = table.rows[i];
        let chkbox = row.cells[0].childNodes[0];
        if(null != chkbox && true == chkbox.checked) {
            table.deleteRow(i);
            rowCount--;
            i--;
        }
    }
    }catch(e) {
        alert(e);
    }
}
//funcion para agregar los participantes a un select 