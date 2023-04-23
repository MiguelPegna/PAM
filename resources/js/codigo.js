const btn_agregar = document.getElementById('agregar');
btn_agregar.addEventListener("click", function(){
    //crear el div que contiene los 3 sub-divs
    const div_principal = D.create('div');
    //crear el div para el span e input de titulo
    const div_titulo = D.create('div');
    //crear el div para el span e input de fecha 
    const div_fecha = D.create('div');
    //crear el div para el span e input de responsable
    const div_responsable = D.create('div');
    //crear los span para titulo,fecha y responsable
    const b_titulo = D.create('b',{innerHTML: '<label for="titulo" class="control-label">Titulo<span class="asteriscoData form-text">*</span></label>'}); 

    const b_fecha = D.create('b',{innerHTML: '<label for="fecha" class="control-label">Fecha<span class="asteriscoData form-text">*</span></label>'});

    const b_responsable = D.create('b',{innerHTML: '<label for="responsable" class="control-label">Responsable<span class="asteriscoData form-text">*</span></label>'});

    //crear los inputs de titulo,fecha y responsable 
    const input_titulo = D.create('input',{ type: 'text', className: 'form-control', name: 'tituloA[]', autocomplete: 'off'});

    const input_fecha = D.create('input',{ type: 'date', className: 'form-control', name: 'fechaA[]', autocomplete: 'off'});
  
    const input_responsable = D.create('input',{ type: 'text', className: 'form-control', name: 'responsable[]', autocomplete: 'off'});

    //crear un boton que me permite eliminar
    const borrar = D.create('a',{href:'javascript:void(0)',  innerHTML: 'X', onclick: function( ){D.remove(div_principal); } } );
    //agregar cada etiqueta a su nodo padre
   D.append(b_titulo, div_titulo); 
   D.append(input_titulo, div_titulo); 


   D.append([b_fecha, input_fecha],div_fecha);
  
   D.append([b_responsable, input_responsable],div_responsable);
   D.append([div_titulo,div_fecha,div_responsable,borrar], div_principal);
    //agregar el div del primer comentario al contenedor 
   D.append(div_principal, D.id('c-acuerdos') );
});