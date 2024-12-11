//control alertas
const alertas = document.querySelector('.alertas');
const exito = document.querySelector('.exito');
const error = document.querySelector('.error');
const scroll = document.querySelector('.scroll');

const reserva = {
    id : '',
    nombre : '',
    email : '',
    personas : '',
    fecha : '',
    hora : ''
};

document.addEventListener('DOMContentLoaded', function(){
    iniciarApp();
});

function iniciarApp(){
    alertasFormulario();
    nombreCliente();
    emailCliente();
    numeroPersonas();
    seleccionarHora();
    seleccionarFecha();
}

// Alerta exito y error
function alertasFormulario(){
    // Alerta exito
    if(exito){
        // Hidden al formulario
        const formulario = document.querySelector('.formulario');
        formulario.classList.add('hidden');
        // Scroll alerta
        scroll.scrollIntoView({ behavior : "instant"});
        // Mostrar info al enviar el formulario
        const alertaExito = document.querySelector('.alerta');
        alertaExito.classList.add('final');
        const indicaciones = document.createElement('P');
        indicaciones.classList = "indicaciones";
        indicaciones.textContent = 'Le enviaremos la información de la reserva a su correo electronico.';
        alertas.appendChild(indicaciones);
        // Redirigir al home
        //setTimeout(() => {
          //  location.href = '/';
            //exito.remove();
        //},5000); 

    }else if(error){
        // Scroll alerta
        scroll.scrollIntoView({ behavior : "instant"});
        // Quitar alertas previas
        const alertaBack = document.querySelectorAll('.alerta');
        alertaBack.forEach(alerta => {
            setTimeout(() => {
                alerta.remove();
            }, 3000);
        });
        
    }
}

// Nombre cliente
function nombreCliente(){
    // Input nombre
    const inputNombre = document.querySelector('#nombre');
    // Event input
    inputNombre.addEventListener('input', function(e){
        // Validar nombre
        let nombre = e.target.value;
        nombre = validarNombre(nombre);
        // True
        if(nombre){
            let resultado = e.target.value;
            resultado = resultado.trim();
            reserva.nombre = resultado;
            //console.log(reserva.nombre);
        }else{
            // False
            e.target.value = "";
            // Error
            mostrarAlerta('error', 'El nombre debe contener solo letras');
        }
    })
}
// Funcion validar nombre
function validarNombre(nombre){
    // Expresión regular que permite validar solo letras, espacios y tíldes
    let regex = /^[a-zA-Z\ áéíóúÁÉÍÓÚñÑ\s]*$/; 
    nombre = regex.test(nombre); 
    if (nombre) { 
        return true;
    }
}
// Email Cliente
function emailCliente(){
    // Input email
    const inputEmail = document.querySelector('#email');
    // Event email
    inputEmail.addEventListener('input', function(e){
        let email = e.target.value;
        // Validar email
        email = validarEmail(email);
        // True
        if(email){
            let resultado = e.target.value;
            resultado = resultado.trim();
            reserva.email = resultado;
            mostrarAlerta('exito', 'Email válido');
            //console.log(reserva.email);
        }else{
            // False , mostrar alerta
            mostrarAlerta('error', 'Email no válido o incompleto');
        }
    })
}

// Funcion validar email
function validarEmail(email){
    // Expresión regular para validar un correo electrónico
    let regex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
    email = regex.test(email);
    if(email){
        return true;
    }
}

// Número de personas
function numeroPersonas(){
    const inputPersonas = document.querySelector('#personas');
    inputPersonas.addEventListener('change', function(e){
        // No es editable
         reserva.personas = e.target.value; 
    })
}

// Hora
function seleccionarHora(){
    // Input hora
    const inputHora = document.querySelector('#hora');
    // Hora actual
    let date = new Date();
    let hora = date.getHours();
    let minutos = date.getMinutes();
    let dia = date.getDate();
    let mes = date.getMonth() + 1;
    let anio = date.getFullYear();
    let fecha = anio+"-"+mes+"-"+dia;

    // Hora seleccionada por el cliente
    inputHora.addEventListener('change', function(e){
        let horaSeleccionada = e.target.value;
        // Manejo hora mediante split
        let horaReserva = horaSeleccionada.split(":")[0];
        let minutosReserva = horaSeleccionada.split(":")[1];

        // Validar minutos, no permitir la seleccion de minutos que no sean 00 o 30
        if(horaSeleccionada){
            if(minutosReserva < 30){
                minutosReserva = 30;
            }
            if(minutosReserva > 30) {
                minutosReserva = 0+"0";
                horaReserva++;
            }
        }
        // Asignar nuevo valor
        horaSeleccionada = horaReserva + ":" + minutosReserva;
        e.target.value = horaSeleccionada;

        // Si hay cambio de fecha se resetea la hora
        const inputFechaCliente = document.querySelector('.fecha');
        inputFechaCliente.addEventListener('change', function(){
            e.target.value = "";
        })
        // Input fecha cliente
        const inputFechaActual = document.querySelector('.fecha').value;
        // Validar hora y minutos actuales
        if ( hora < 10 ) {hora = "0"+hora}
        if ( minutos < 10 ) { minutos = "0"+minutos }

        if(minutos < 30){
            minutos = 30;
        }
        if(minutos > 30) {
            minutos = 0+"0";
            hora++;
        }
        // Asignar valor min
        // Si la fecha actual es igual al valor del input fecha cliente, asignamos el valor de min la hora actual NO la hora de apertura
        if(fecha === inputFechaActual){
            let min = hora+":"+minutos;
            inputHora.setAttribute('min',min);
            if(e.target.value < min){
                e.target.value = "";
                mostrarAlerta('error', 'Hora anterior a la actual, por favor verifique fecha y hora');
            }
        }else{
            // Si no son iguales, asignamos el valor min === a la hora de apertura "07:00";
            inputHora.removeAttribute('min',hora+":"+minutos);
            inputHora.setAttribute('min',"07:00");
            // Si se selecciona una hora inferior a la hora de apertura y la fecha  es diferente a la fecha actual mostramos error
            if(e.target.value < "07:00" && fecha !== inputFechaActual){
                e.target.value = "";
                mostrarAlerta('error', 'Consulte horario de apertura');
            }
        }
        // Asignar valor max
        inputHora.setAttribute('max',"19:00");
        if(e.target.value > "19:00"){
            e.target.value = "";
            mostrarAlerta('error', 'Acceptamos reservas hasta las 19:00');
        }

        reserva.hora = e.target.value;
    })
}

// Fecha
function seleccionarFecha(){
    // Input fecha
    const inputFecha = document.querySelector('#fecha');
    // Fecha actual
    let date = new Date();
    let dia = date.getDate();
    let mes = date.getMonth() + 1;
    let anio = date.getFullYear();
    
    // Validar dia y mes
    if ( dia < 10 ) {dia="0"+dia}
    if ( mes < 10 ) { mes="0"+mes }
    // Valor min
    inputFecha.setAttribute('min',anio+"-"+mes+"-"+dia);
   
    // Event input fecha
    inputFecha.addEventListener('input', function(e){
        inputFecha.setAttribute('value', "");
        // Devolver el dia 0-6 , con "N" devuelve de 1 al 7, no permitir seleccionar el fin de semana
        const finde = new Date(e.target.value).getUTCDay();
        if([6,0].includes(finde)){
            e.target.value = "";
            mostrarAlerta('error', 'Fines de semana no permitidos, por favor contacta con nosotros');
        }else{
            reserva.fecha = e.target.value;
        }
    })
}
 
// Alerta
function mostrarAlerta(tipo, mensaje, desaparece=true){
    // Scroll a h2
    scroll.scrollIntoView({ behavior : "instant"});
    // Previene que se genere más de una alerta
    const alertaPrevia = document.querySelector('.alerta');
    if(alertaPrevia) {
        alertaPrevia.remove();
    }
    // Scripting alerta
    const divAlerta = document.createElement('DIV');
    divAlerta.textContent = mensaje;
    divAlerta.className = `alerta ${tipo}`;
    alertas.appendChild(divAlerta);

    // Eliminar la alerta
    if(desaparece){
        setTimeout(() => {
            divAlerta.remove();
        }, 3000);
    }

}

