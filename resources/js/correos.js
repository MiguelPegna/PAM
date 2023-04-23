//funcion para validar formulario de la minuta 
document.addEventListener('DOMContentLoaded', function(){
    var formCorreos = document.querySelector("#formCorreos");
    formCorreos.onsubmit = function(e) {
        e.preventDefault();
        //definir variables del formulario
        var t1 = document.querySelector('#t1').value;
        var t2 = document.querySelector('#t2').value;


        if(t1== '' || t2== '' ){    
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
        
        //NUEVO minuta
        var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        var ajaxUrl = base_url+'correos/setCorreo';
        var formData = new FormData(formCorreos);

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
                    }).then((result) => {
                        if(result.isConfirmed){
                            alert('ha Cuajado');
                        }
                    });//end then;   
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
    fntCargos();
    fntParticipantes();
    fntIdMin();
    fntTitulos();
}, false);


   


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
    var ajaxUrl = base_url+'minutas/getSelectParticipantes';
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

//funcion para obtener el ultimo id de minuta en la DB
function fntIdMin(){
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    var ajaxUrl = base_url+'minutas/getIdMinuta';
    request.open('GET', ajaxUrl, true);
    request.send();

    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            document.querySelector('#divId').innerHTML = request.responseText;

        }
    }
}

$().ready(function(){
	$('#addP').click(function() {
        return !($('#userS option:selected').clone()).appendTo('.responsable');           
	});
 
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