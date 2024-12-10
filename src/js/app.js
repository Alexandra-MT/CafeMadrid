//cargamos pagina
document.addEventListener('DOMContentLoaded', function() {
    cambiarHeader();
});

//header cada página

function cambiarHeader(){
    const nav = document.querySelectorAll('.nav-principal a');
    const headerClass = document.querySelector('header');
    nav.forEach(a =>{
        if(a.className == 'activo'){
            const clase = a.text;
            let minClase = clase.toLowerCase();
            //eliminar tildes  String.prototype.normalize()
            minClase = minClase.normalize('NFD').replace(/[\u0300-\u036f]/g,"");
            headerClass.classList.add(`header-${minClase}`);
            if(minClase === 'menu'){
                const menu = document.querySelector('.menu-principal');
                menu.classList.add('imagen-fondo');
                const footerMenu = document.querySelector('.footer');
                footerMenu.classList.add('footer-menu');
            }
        }
    })    
} 



