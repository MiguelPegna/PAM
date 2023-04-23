function verPass01(){
    let swap01= document.querySelector('.ver01');
    let elemento = document.querySelector('#ojo');
    if(swap01.type == 'password' && elemento.className == 'glyphicon glyphicon-eye-open' ){
        swap01.type = 'text';
        elemento.className = 'glyphicon glyphicon-eye-close';
    }
    else{
        swap01.type= 'password';
        elemento.className = 'glyphicon glyphicon-eye-open';
    }
}
//Esta funcion es para la vista de registro para el campo de repetir contraseña
function verPass02(){
    let swap02= document.querySelector('.ver02');
    if(swap02.type == 'password' && elemento.className == 'glyphicon glyphicon-eye-open' ){
        swap02.type = 'text';
        elemento.className = 'glyphicon glyphicon-eye-close';
    }
    else{
        swap02.type= 'password';
        elemento.className = 'glyphicon glyphicon-eye-open';
    }
}

//funciones para la validacion correcta de información de los formularios
//funcion que solo permite escribir numeros
function controlTag(e){
    tecla=(document.all) ? e.keyCode : e.which;
    if(tecla==8) return true;
    else if(tecla==0|| tecla==9) return true;
    patron =/[0-9-\s]/;
    n=String.fromCharCode(tecla);
    return ProcessingInstruction.test(n);
}

//funcion que soo permite la entrada de letras
function testText(txtString){
    var txt= new RegExp(/^[a-zA-ZÑñÁáÉéÍíÓóÚúÜüÖö\s]+$/);
    if(txt.test(txtString)){
        return true;
    }
    else{
        return false;
    }
}

//validar una direccion de correo valida
function testMail(email){
    var mail = new RegExp(/^([a-zA-Z0-9_.+-])+\@(([a-zA-z0-9-])+\.)+([a-zA-z0-9]{2,4})+$/);
    if(mail.test(email)== false){
        return false;
    }
    else{
        return true;
    }
}

//funciones para realizar la validacion con la info del formulario
function validTxt(){
    let checkTxt= document.querySelectorAll('.validTxt');
    checkTxt.forEach(function(checkTxt){
        checkTxt.addEventListener('keyup', function(){
            let inputVal = this.value;
            if(!testText(inputVal)){
                this.classList.add('form-control-error');
            }
            else{
                this.classList.remove('form-control-error');
            }
        });
    });
}

function validMail(){
    let checkMail= document.querySelectorAll('.validMail');
    checkMail.forEach(function(checkMail){
        checkMail.addEventListener('keyup', function(){
            let inputVal = this.value;
            if(!testMail(inputVal)){
                this.classList.add('form-control-error');
            }
            else{
                this.classList.remove('form-control-error');
            }
        });
    });
}

window.addEventListener('load', function(){
    validTxt();
    validMail();
})