// Referencia scroll
const scroll = document.querySelector('#scroll');
// Contenedor entradas
const listadoArticulosDOM = document.querySelector("#contenido-blog");
// Botón atrás
const botonAtrasDOM = document.querySelector("#atras");
// Número página/páginas disponibles
const informacionPaginaDOM = document.querySelector("#informacion-pagina");
// Botón siguiente
const botonSiguienteDOM = document.querySelector("#siguiente");
// Elementos por página a mostrar
const elementosPorPagina = 9;
// Página actual
let paginaActual = 1;  

// Consultar las entradas del blog mediante Api
async function entradasBlog(){
    const url = '${location.origin}/api/blog';
    //const url = 'http://localhost:3000/api/blog';
    const resultado = await fetch(url);
    const entradas = await resultado.json();
    mostrarEntradas(entradas);
}

// Siguiente página
function avanzarPagina() {
// Incrementar "paginaActual"
paginaActual = paginaActual + 1;
scroll.scrollIntoView({behavior: 'smooth'});
// Redibujar
renderizar();
}

// Anterior página
function retrocederPagina() {
// Disminuye "paginaActual"
paginaActual = paginaActual - 1;
scroll.scrollIntoView({behavior: 'smooth'});
// Redibujar
renderizar();
}

// Mostrar entradas blog
function mostrarEntradas(entradas){
    // Limpiamos los artículos anteriores del DOM
    listadoArticulosDOM.innerHTML = "";

    // Obtenemos los artículos paginados
    const corteDeInicio = (paginaActual - 1) * elementosPorPagina;
    const corteDeFinal = corteDeInicio + elementosPorPagina;
    const corte = entradas.slice(corteDeInicio, corteDeFinal);

    // Número total de páginas disponibles
    const paginas = Math.ceil(entradas.length / elementosPorPagina);

    // Comprobar que no se pueda retroceder
	if (paginaActual === 1) {
		botonAtrasDOM.setAttribute("disabled", true);
	} else {
		botonAtrasDOM.removeAttribute("disabled");
	}
	// Comprobar que no se pueda avanzar
	if (paginaActual === paginas) {
		botonSiguienteDOM.setAttribute("disabled", true);
	} else {
		botonSiguienteDOM.removeAttribute("disabled");
	}

    // Informar de página actual y páginas disponibles
	informacionPaginaDOM.textContent = `${paginaActual}/${paginas}`;

    // Crear un artículo para cada elemento que se encuentre en la página actual
    corte.forEach(datosEntrada => {
        // Utilizamos destructuring para extraer el valor de los variables
        const {id, imagen, titulo, fecha, autor} = datosEntrada;

        // Contenedor Imagen
        const imagenEntrada = document.createElement('DIV');
        imagenEntrada.classList.add('imagen');

        // Imagen
        const imagenCont = document.createElement('IMG');
        imagenCont.setAttribute ("src", `/build/img/blog/${imagen}`);
        imagenCont.setAttribute ("alt", "imagen-entrada");

        imagenEntrada.appendChild(imagenCont);

        // Contenedor texto entrada
        const infoEntrada = document.createElement('DIV');
        infoEntrada.classList.add('texto-entrada');

        // Enlace entrada
        const enlaceEntrada = document.createElement('A');
        enlaceEntrada.onclick = function(){
            seleccionarEntrada(datosEntrada);
            scroll.scrollIntoView({behavior: 'instant'});
        }
        //enlaceEntrada.setAttribute ('href', `/entrada?id=${id}`);

        // Titulo entrada
        const tituloEntrada = document.createElement('H4');
        tituloEntrada.textContent = titulo;

        enlaceEntrada.appendChild(tituloEntrada);

        infoEntrada.appendChild(enlaceEntrada);

        // Contenedor artículos
        const contenedor = document.createElement('ARTICLE');
        contenedor.classList.add('entrada-blog');
 
        contenedor.appendChild(imagenEntrada);
        contenedor.appendChild(infoEntrada);

        document.querySelector('.contenido-blog').appendChild(contenedor);

    })  
}

function seleccionarEntrada(datosEntrada){
    // Desactivar boton retroceso
    nobackbutton();

    // Variables datosEntrada
    const {id, titulo, imagen, fecha, autor, introduccion, contenido} = datosEntrada;

    // Limpiamos los artículos anteriores del DOM
    listadoArticulosDOM.innerHTML = "";
    botonAtrasDOM.style.visibility = 'hidden';
    informacionPaginaDOM.textContent = "";
    botonSiguienteDOM.style.visibility = 'hidden';
    listadoArticulosDOM.classList = 'contenido-entrada';
    listadoArticulosDOM.id = 'contenido-entrada';

    const contenedorIntro = document.createElement('DIV');
    contenedorIntro.classList.add('introduccion-entrada');

    const introEntrada = document.createElement('P');
    introEntrada.textContent = introduccion;

    contenedorIntro.appendChild(introEntrada);

    const imagenCont = document.createElement('IMG');
    imagenCont.setAttribute ("src", `/build/img/blog/${imagen}`);
    imagenCont.setAttribute ("alt", "imagen-entrada");

    // Formatear fecha
    const fechaObj = new Date(fecha);
    const mes = fechaObj.getMonth();
    const dia = fechaObj.getDate();
    const anio = fechaObj.getFullYear();

    const fechaUTC = new Date(Date.UTC(anio, mes, dia));
    const opciones = { year:'numeric', month:'long', day:'numeric'};
    const fechaFormateada = fechaUTC.toLocaleDateString('es-ES', opciones);

    const info = document.createElement('P');
    info.innerHTML = `Escrito el <span>${fechaFormateada}</span> por <span>${autor}</span>`;

    const cont = document.createElement('P');
    cont.textContent = contenido;

    const contenedor = document.createElement('ARTICLE');
    contenedor.classList.add('entrada-blog');

    contenedor.appendChild(contenedorIntro);
    contenedor.appendChild(imagenCont);
    contenedor.appendChild(info);
    contenedor.appendChild(cont);

    const volver = document.createElement('A');
    volver.classList = 'boton boton-secundario-block';
    volver.textContent = 'Volver';
    volver.setAttribute('href', '/blog');
    
    const contenedorVolver = document.querySelector('.botones');
    contenedorVolver.appendChild(volver);

    document.querySelector('.contenido-entrada').appendChild(contenedor);
    document.querySelector('.contenido-entrada').appendChild(contenedorVolver);

}

botonAtrasDOM.addEventListener("click", retrocederPagina);
botonSiguienteDOM.addEventListener("click", avanzarPagina);

function nobackbutton(){	
    for(x=0;x<2;x++){
    window.history.pushState(null, "", window.location.href);
    }
 }

function renderizar(){
    entradasBlog();
}

renderizar();

console.log(window.location);