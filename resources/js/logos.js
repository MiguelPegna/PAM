//funcion para validar formulario del logo 
document.addEventListener('DOMContentLoaded', function(){
    var formLogo = document.querySelector("#formLogo");
    formLogo.onsubmit = function(e) {
        e.preventDefault();
        //definir variables del formulario
        var strNomLogo = document.querySelector('#nombreLogo').value;
        var intAnho = document.querySelector('#anho').value;
        var intUso = document.querySelector('#usoPara').value;
        var strLogo = document.querySelector('#logo').value;

        if(strNomLogo==''||intAnho== ''||intUso== ''||strLogo== ''){
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
        var ajaxUrl = base_url+'logos/setLogo';
        var formData = new FormData(formLogo);

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
                    setTimeout(location.href='portal',5000);
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

    var formLogoMinuta = document.querySelector("#formLogoMinuta");
    formLogoMinuta.onsubmit = function(e) {
        e.preventDefault();
        //definir variables del formulario
        var intLogoMin = document.querySelector('#logoMin').value;
        var intPiePagMin = document.querySelector('#piePagMin').value;

        if(intLogoMin==''||intPiePagMin== ''){
            Swal.fire({
                width: '35%',
                icon: 'error',
                title: '<h3>Oops...</h3>',
                html: '<h4>Selecciona un logo y pie de pag. >:{</h4>',
                confirmButtonColor: '#13322B',
                confirmButtonText: '<h5>Aceptar</h5>'
            });
            return false;
        }
        
        //Actualizar logos de minuta
        var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        var ajaxUrl = base_url+'logos/chooseLogoMinuta';
        var formData = new FormData(formLogoMinuta);

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
    //Actualizar logos de reportes
    var formLogoReporte = document.querySelector("#formLogoReporte");
    formLogoReporte.onsubmit = function(e) {
        e.preventDefault();
        //definir variables del formulario
        var intLogoIzq = document.querySelector('#logoRepIzq').value;
        var intLogoDer = document.querySelector('#logoRepDer').value;
        var intPiePagRep = document.querySelector('#piePagRep').value;


        if(intLogoIzq==''||intLogoDer== ''||intPiePagRep== ''){
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
        var ajaxUrl = base_url+'logos/chooseLogoReporte';
        var formData = new FormData(formLogoReporte);

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
    
}, false);

window.addEventListener('load', function(){
    fntLogosMin();
    fntLogosRepIzq();
    fntLogosRepDer();
    fntPiePag();
}, false);

//funcion para obtener los logos de minutas de la DB
function fntLogosMin(){
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    var ajaxUrl = base_url+'logos/getSelectLogosMin';
    request.open('GET', ajaxUrl, true);
    request.send();

    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            document.querySelector('#logoMin').innerHTML = request.responseText;
        }
    }
}

//funcion para obtener los logos de minutas de la DB
function fntLogosRepIzq(){
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    var ajaxUrl = base_url+'logos/getSelectLogosRepIzq';
    request.open('GET', ajaxUrl, true);
    request.send();

    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            document.querySelector('#logoRepIzq').innerHTML = request.responseText;
        }
    }
}

//funcion para obtener los logos de minutas de la DB
function fntLogosRepDer(){
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    var ajaxUrl = base_url+'logos/getSelectLogosRepDer';
    request.open('GET', ajaxUrl, true);
    request.send();

    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            document.querySelector('#logoRepDer').innerHTML = request.responseText;
        }
    }
}

//funcion para obtener los logos de minutas de la DB
function fntPiePag(){
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    var ajaxUrl = base_url+'logos/getSelectPiePag';
    request.open('GET', ajaxUrl, true);
    request.send();

    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            document.querySelector('#piePagMin').innerHTML = request.responseText;
            document.querySelector('#piePagRep').innerHTML = request.responseText;
            //document.querySelector('#rolS').value=1;
            //$('#rolS').selectpicker('render');
        }
    }
}

//script para vista previa del logo
function archivo(evt) {
    var files = evt.target.files; // FileList object

    // Obtenemos la imagen del campo "file".
    for (var i = 0, f; f = files[i]; i++) {
      //Solo admitimos imÃ¡genes.
      if (!f.type.match('image.*')) {
        continue;
      }

      var reader = new FileReader();

      reader.onload = (function(theFile) {
        return function(e) {
          // Insertamos la imagen
         document.querySelector("#preview").innerHTML = ['<img class="thumb" src="', e.target.result,'" title="', escape(theFile.name), '" width="300" height="420">'].join('');
        };
      })(f);

      reader.readAsDataURL(f);
    }
  }

  document.querySelector('#logo').addEventListener('change', archivo, false);
