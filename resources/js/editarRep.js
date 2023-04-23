//funcion para validar formulario de la minuta 
document.addEventListener('DOMContentLoaded', function(){
    var formReporte = document.querySelector("#formReporte");
    formReporte.onsubmit = function(e) {
        e.preventDefault();
        //definir variables del formulario
        var strTituloRep = document.querySelector('#titulo').value;
        var strFechaInc = document.querySelector('#fechaInc').value;
        var strIncidente = document.querySelector('#incidente').value;
        var strCaso = document.querySelector('#caso').value;
        var strEtiqueta = document.querySelector('#etiqueta').value;
        var strModelo = document.querySelector('#modelo').value;
        var strFabricante = document.querySelector('#fabricante').value;
        var strNumSerie = document.querySelector('#numSerie').value;
        var strPersona = document.querySelector('#persona').value;
        var strDescripcion = document.querySelector('#descripcion').value;
        var strOrigen = document.querySelector('.origen').value;
        var strFechaCad = document.querySelector('.fechaCad').value;
        var strRazon = document.querySelector('.razon').value;
        var strDestino = document.querySelector('.destino').value;
        var strDisposicion = document.querySelector('#disposicion').value;
        var strFechaF = document.querySelector('#fechaFinal').value;

        if(strTituloRep==''||strFechaInc== ''||strIncidente== ''||strCaso== ''||strEtiqueta== ''||strModelo==''||strFabricante==''||strNumSerie==''||strPersona==''||strDescripcion==''||strOrigen==''||strFechaCad==''||strRazon=='' ||strDestino==''||strDisposicion==''||strFechaF==''){
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
        
        //Actualizar Reporte
        var idReporte = document.querySelector('#idReporte').value;
        var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        var ajaxUrl = base_url+'editarRep/updateReporte/'+idReporte;
        var formData = new FormData(formReporte);

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
                    setTimeout(location.href='listarep',5000);
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

    //FORMULARIO DE PERSONA
    var formPersona = document.querySelector("#formPersona");
    formPersona.onsubmit = function(e) {
        e.preventDefault();
        //Declaracion de variables del formulario
        var nombre = document.querySelector('#nPersona').value; 
        var intTipo = document.querySelector('#listStatus').value; 

        var minimo =8;
        var limite = 30;
        if(nombre== '' || nombre.length < minimo || nombre.length > limite){    
            Swal.fire({
                width: '35%',
                icon: 'error',
                title: '<h3>Oops...</h3>',
                html: '<h4>Introduce el nombre completo de la persona >:{</h4>',
                confirmButtonColor: '#13322B',
                confirmButtonText: '<h5>Aceptar</h5>'
            });
            return false;
        }
        //peticion Request para insertar persona a la DB
        //Agregar NUEVO receptor a la DB
        var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        var ajaxUrl = base_url+'editarRep/setReceptor';
        var formData = new FormData(formPersona);

        request.open("POST",ajaxUrl,true);
        request.send(formData);
        request.onreadystatechange = function(){
            if(request.readyState == 4 && request.status == 200){
                var objData = JSON.parse(request.responseText);
                if(objData.status){
                    $('#newPersona').modal('hide');
                    formPersona.reset();
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
    fntRep();
    fntCadenas();
}, false);



    //funcion para obtener el ultimo id de minuta en la DB
function fntRep(){
    var idReporte = document.querySelector('#idReporte').value;
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    var ajaxUrl = base_url+'editarRep/getReporte/'+idReporte;
    request.open('GET', ajaxUrl, true);
    request.send();
    
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            var objData= JSON.parse(request.responseText);

            if(objData.status){
                document.querySelector('#titulo').value= objData.data.titulo;
                document.querySelector('#fechaInc').value= objData.data.fechaInc;
                document.querySelector('#incidente').value= objData.data.incidente;
                document.querySelector('#caso').value= objData.data.caso;
                document.querySelector('#consentimiento').value= objData.data.consentimiento;
                document.querySelector('#etiqueta').value= objData.data.etiqueta;
                document.querySelector('#modelo').value= objData.data.modelo;
                document.querySelector('#fabricante').value= objData.data.fabricante;
                document.querySelector('#numSerie').value= objData.data.numSerie;
                document.querySelector('#persona').value= objData.data.receptor;
                document.querySelector('#descripcion').value= objData.data.descripcion;
                document.querySelector('#disposicion').value= objData.data.disposicion;
                document.querySelector('#fechaFinal').value= objData.data.fechaFinal;
                document.querySelector('#idRecep').value= objData.data.idPersona;
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

//funcion para obtener cadena de evidencias del reporte de la DB
function fntCadenas(){
    var idReporte = document.querySelector('#idReporte').value;
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    var ajaxUrl = base_url+'editarRep/getEvidencias/'+idReporte;
    request.open('GET', ajaxUrl, true);
    request.send();

    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            document.querySelector('#td-content').innerHTML = request.responseText;
        }
    }
}

//buscador de personas
$(document).ready(function() {
    $('#persona').on('keyup', function() {
        var persona = $(this).val();		
        var dataString = 'persona='+persona;
	    if(persona.length>0){
            $.ajax({
                type: "POST",
                url: base_url+'reportes/getPersona',
                data: dataString,
                success: function(data) {
                    //Escribimos las sugerencias que nos manda la consulta
                    $('#suggestions').fadeIn(1000).html(data);
                    //Al hacer click en algua de las sugerencias
                    $('.suggest-element').on('click', function(){
                            //Obtenemos la id unica de la sugerencia pulsada
                            var idP = $(this).attr('id');
                            //Editamos el valor del input con data de la sugerencia pulsada
                            $('#persona').val($('#'+idP).attr('data'));
                            //Hacemos desaparecer el resto de sugerencias
                            $('#suggestions').fadeOut(1000);
                            //alert('Has seleccionado el '+id+' '+$('#'+id).attr('data'));
                            return false;
                    });
                }
            });
        }
        else{
            $('#suggestions').fadeOut(1000);
        }
        });
});

//funcion de agregar nueva cadena de evidencias
let nvoCadenas=1;
let nvoNumOrigen=1;
let nvoNumDate=1;
let nvoNumRazon=1;
let nvoNumDestino=1;
let nvoNumPrueba=1;

function addRow(tableID) {
    
    if (nvoCadenas<50) {
        
        let table = document.getElementById(tableID);
        
        let rowCount = table.rows.length;
        let row = table.insertRow(rowCount);

        let cell1 = row.insertCell(0);
        let element1 = document.createElement("input");
        cell1.className = "form-control";
        element1.type = "checkbox";
        element1.name="nvoChkbox[]";
        element1.className="nvoCheck";
        nvoCadenas++;
        cell1.appendChild(element1);
        
        let cell2 = row.insertCell(1); 
        let element2 = document.createElement("input");
        cell2.className="col-md-3 td-a";
        element2.type = "text";
        element2.setAttribute("id", "nvoOrigen[]");
        element2.name = "nvoOrigen[]";
        element2.className = "form-control origen nvoOrigen";
        nvoNumOrigen++;
        element2.value = nvoCadenas;
        cell2.appendChild(element2);

        let cell3 = row.insertCell(2); 
        let element3 = document.createElement("input");
        cell3.className="col-md-3 td-a";
        element3.type = "date";
        element3.setAttribute("id", "nvoFechaCad[]");
        element3.name = "nvoFechaCad[]";
        element3.className = "form-control fechaCad nvoFechaCad";
        nvoNumDate++;
        cell3.appendChild(element3);

        let cell4 = row.insertCell(3); 
        let element4 = document.createElement("input");
        cell4.className="col-md-3 td-a ";
        element4.setAttribute("id", "nvoRazon[]");
        element4.name = "nvoRazon[]";
        element4.className = "form-control razon nvoRazon";
        nvoNumRazon++;      
        cell4.appendChild(element4);

        let cell5 = row.insertCell(4); 
        let element5 = document.createElement("input");
        cell5.className="col-md-3 td-a ";
        element5.setAttribute("id", "nvoDestino[]");
        element5.name = "nvoDestino[]";
        element5.className = "form-control destino nvoDestino";
        nvoNumDestino++;      
        cell5.appendChild(element5);

        let cell6 = row.insertCell(5); 
        let element6 = document.createElement("input");
        element6.type = "file"
        cell6.className="col-md-3 td-a ";
        element6.setAttribute("id", "nvoPrueba[]");
        element6.name = "nvoPrueba[]";
        element6.className = "form-control prueba nvoPrueba";
        nvoNumPrueba++;      
        cell6.appendChild(element6);
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