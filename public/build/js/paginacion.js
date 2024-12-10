const listadoArticulosDOM = document.querySelector("#listado-articulos");
const botonAtrasDOM = document.querySelector("#atras");
const informacionPaginaDOM = document.querySelector("#informacion-pagina");
const botonSiguienteDOM = document.querySelector("#siguiente");
const plantillaArticulo = document.querySelector("#plantilla-articulo").content.firstElementChild;
const elementosPorPagina = 9;
let paginaActual = 1;
let entradas = [];


function avanzarPagina() {
    // Incrementar "paginaActual"
    paginaActual = paginaActual + 1;
    // Redibujar
    renderizar();
}

function retrocederPagina() {
    // Disminuye "paginaActual"
    paginaActual = paginaActual - 1;
    // Redibujar
    renderizar();
}

async function consultarApiBlog(){
    try{
    const url = 'http://localhost:3000/api/blog';
    const resultado = await fetch(url);
    const entradas = await resultado.json();
    return entradas;
    }catch{
        console.log('ERROR');
    }
}

entradas = consultarApiBlog();

function obtenerRebanadaDeBaseDeDatos(pagina = 1) {
    const corteDeInicio = (paginaActual - 1) * elementosPorPagina;
    const corteDeFinal = corteDeInicio + elementosPorPagina;
    const resultado = entradas.slice(corteDeInicio, corteDeFinal);
    return resultado;
}

function obtenerPaginasTotales() {
    return Math.ceil(resultado.length / elementosPorPagina);
}

function gestionarBotones() {
    // Comprobar que no se pueda retroceder
    if (paginaActual === 1) {
    botonAtrasDOM.setAttribute("disabled", true);
    } else {
    botonAtrasDOM.removeAttribute("disabled");
    }
    // Comprobar que no se pueda avanzar
    if (paginaActual === obtenerPaginasTotales()) {
    botonSiguienteDOM.setAttribute("disabled", true);
    } else {
    botonSiguienteDOM.removeAttribute("disabled");
    }
}

function renderizar() {
    // Limpiamos los artículos anteriores del DOM
    listadoArticulosDOM.innerHTML = "";
    // Obtenemos los artículos paginados
    const rebanadaDatos = obtenerRebanadaDeBaseDeDatos(paginaActual);
    //// Dibujamos
    // Deshabilitar botones pertinentes (retroceder o avanzar página)
    gestionarBotones();
    // Informar de página actual y páginas disponibles
    informacionPaginaDOM.textContent = `${paginaActual}/${obtenerPaginasTotales()}`;
    // Crear un artículo para cada elemento que se encuentre en la página actual
    rebanadaDatos.forEach(function (datosArticulo) {
      // Clonar la plantilla de artículos
      const miArticulo = plantillaArticulo.cloneNode(true);
      // Rellenamos los datos del nuevo artículo
      const miTitulo = miArticulo.querySelector("#titulo");
      miTitulo.textContent = datosArticulo.title;
      const miCuerpo = miArticulo.querySelector("#cuerpo");
      miCuerpo.textContent = datosArticulo.body;
      // Lo insertamos dentro de "listadoArticulosDOM"
      listadoArticulosDOM.appendChild(miArticulo);
    });
}

// --
// Eventos
// --
botonAtrasDOM.addEventListener("click", retrocederPagina);
botonSiguienteDOM.addEventListener("click", avanzarPagina);

// --
// Inicio
// --
renderizar(); // Mostramos la primera página nada más que carge la página
