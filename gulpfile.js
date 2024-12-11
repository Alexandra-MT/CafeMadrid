//done()//decir a gulp cuando la tarea ha finalizado para evitar errores
//exports, ejecutable por medio de gulp, manda a llamar las funciones

const { src, dest, watch, series, parallel } = require('gulp'); //{} exporta mas de una funcion
const sass = require('gulp-sass')(require('sass')); //exporta solo una funcion, compila la hoja de estilos
const postcss = require('gulp-postcss');
const autoprefixer = require('autoprefixer');

//Imagenes
const imagemin = require('gulp-imagemin');
const webp = require('gulp-webp');
const avif = require('gulp-avif');

function css( done ) {
    //compilar sass
    //paso 1: identificar archivo
    src('src/scss/app.scss')
    //compilarla
        .pipe( sass( {outputStyle: 'compressed'} ) )
        .pipe( postcss([ autoprefixer() ]) )
    //guardar el .css
        .pipe( dest('./public/build/css') )
    //terminar tarea
    done();
}

function js( done ) {
    src('src/js/**/*.js')
      .pipe(dest('./public/build/js'));
   done(); 
}

function imagenes( done ){
    src('src/img/**/*')
    .pipe( imagemin({ optimizationLevel:3 }) )
        .pipe( dest('./public/build/img') );
    done();
}

function versionWebp() {
    const opciones = {
        quality: 50
    }
    return src('src/img/**/*.{png,jpg}')
        .pipe( webp( opciones ) )
        .pipe( dest('./public/build/img'));
}

function versionAvif(){
    const opciones = {
        quality: 50
    }
    return src('src/img/**/*.{png,jpg}')
        .pipe( avif( opciones ) )
        .pipe( dest('./public/build/img'));
}

function dev(){
    watch('src/scss/**/*.scss', css);
    watch('src/js/**/*.js', js);
    watch('src/img/**/*', imagenes);
}

//exports, ejecutable por medio de gulp
exports.css = css;
exports.js = js;
exports.dev = dev;
exports.imagenes = imagenes;
exports.versionWebp = versionWebp;
exports.versionAvif = versionAvif;
exports.default = parallel(imagenes, versionWebp, versionAvif, css, js, dev);
exports.build = parallel(imagenes, versionWebp, versionAvif, css, js);

//series - inicia la primera tarea y cuando acaba se inicia la segunda tarea

//parallel - inician las tareas en paralelo