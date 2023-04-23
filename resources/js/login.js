document.addEventListener('DOMContentLoaded', function(){
    if(document.querySelector('#loginForm')){
        let login= document.querySelector('#loginForm');
        loginForm.onsubmit=function(e){
            e.preventDefault();

            let strUsuario= document.querySelector('#email').value;
            let strPass= document.querySelector('#pass').value;

            if(strUsuario=='' || strPass==''){
                Swal.fire({
                    width: '35%',
                    icon: 'error',
                    title: '<h3>Oops...</h3>',
                    html: '<h4>Introduce tu E-mail y contraseña >:{</h4>',
                    confirmButtonColor: '#13322B',
                    confirmButtonText: '<h5>Aceptar</h5>'
                });
                return false;
            }
            else{
                var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                var ajaxUrl = base_url+'Login/loginUser';
                var formData = new FormData(loginForm); 
                request.open("POST",ajaxUrl,true);
                request.send(formData);
                request.onreadystatechange = function(){
                    if(request.readyState !=4) return;
                    if(request.status==200){
                        var objData = JSON.parse(request.responseText);
                        if(objData.status){
                            window.location = base_url+'portal';
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
                    else{
                        Swal.fire({
                            width: '35%',
                            icon: 'error',
                            title: '<h3>Oops...</h3>',
                            html: `<h4>`+'Se acabo todo todillo'+'</h4>',
                            confirmButtonColor: '#13322B',
                            confirmButtonText: '<h5>Aceptar</h5>'
                        });
                    }
                    return false;
                }
            }
        }
    }
}, false);