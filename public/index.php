<?php
namespace App;

//Inicializo sesión para poder traspasar variables entre páginas
session_start();

//Incluyo los controladores que voy a utilizar para que seran cargados por Autoload
use App\Controller\AppController;
use App\Controller\ComponentesController;
use App\Controller\TrabajadorController;
use App\Controller\ReviewsController;

//echo password_hash("Madrid01",  PASSWORD_BCRYPT, ['cost'=>12]); //-->para añadir trabajadores


/*
 * Asigno a sesión las rutas de las carpetas public y home, necesarias tanto para las rutas como para
 * poder enlazar imágenes y archivos css, js
 */
$_SESSION['public'] = '/2Eva/PracticaCMS/public/';
$_SESSION['home'] = $_SESSION['public'].'index.php/';

//Defino y llamo a la función que autocargará las clases cuando se instancien
spl_autoload_register('App\autoload');

function autoload($clase,$dir=null){

    //Directorio raíz de mi proyecto
    if (is_null($dir)){
        $dirname = str_replace('/public', '', dirname(__FILE__));
        $dir = realpath($dirname);
    }

    //Escaneo en busca de la clase de forma recursiva
    foreach (scandir($dir) as $file){
        //Si es un directorio (y no es de sistema) accedo y
        //busco la clase dentro de él
        if (is_dir($dir."/".$file) AND substr($file, 0, 1) !== '.'){
            autoload($clase, $dir."/".$file);
        }
        //Si es un fichero y el nombr conicide con el de la clase
        else if (is_file($dir."/".$file) AND $file == substr(strrchr($clase, "\\"), 1).".php"){
            require($dir."/".$file);
        }
    }

}

//Para invocar al controlador en cada ruta
function controlador($nombre=null){

    switch($nombre){
        default: return new AppController; //Front-end
        case "componentes": return new ComponentesController; //Back-end componentes
        case "reviews": return new ReviewsController;
        case "trabajadores": return new TrabajadorController; //Autentificacion y Back-end de trabajadores

    }

}

//Quito la ruta de la home a la que me están pidiendo
$ruta = str_replace($_SESSION['home'], '', $_SERVER['REQUEST_URI']);
$_SESSION['ruta'] = $ruta;
//Encamino cada ruta al controlador y acción correspondientes
switch ($ruta){

    //Front-end
    case "":
    case "/":
        controlador()->index();
        break;
    case "acerca-de":
        controlador()->acercade();
        break;
    case "componentes":
        controlador()->componentes();
        break;
    case (strpos($ruta,"componente/") === 0): //Si la ruta empieza por "componente/"
        controlador()->componente(str_replace("componente/","",$ruta)); //El parámetro es lo que hayo después de "componentes"
        break;
    case "reviews":
        controlador()->reviews();
        break;
    case (strpos($ruta,"review/") === 0): //Si la ruta empieza por "noticia/"
        controlador()->componente(str_replace("review/","",$ruta)); //El parámetro es lo que hayo después de "componentes"
        break;
    case "foro":
        controlador()->discusiones();
        break;
    case (strpos($ruta,"hilo/") === 0): //Si la ruta empieza por "noticia/"
        controlador()->discusion(str_replace("hilo/","",$ruta)); //El parámetro es lo que hayo después de "componentes"
        break;

    //Back-end
    //General
    case "admin":
    case "admin/entrar":
    case "admin/inicio":
        controlador("trabajadores")->entrar();
        break;
    case "admin/salir":
        controlador("trabajadores")->salir();
        break;
    case "admin/trabajadores"://listar trabajadores
        controlador("trabajadores")->index();
        break;
    //Usuarios
    case "admin/trabajadores/crear":
        controlador("trabajadores")->crear();
        break;
    case (strpos($ruta,"admin/trabajadores/editar/") === 0)://editar el usuario
        controlador("trabajadores")->editar(str_replace("admin/trabajadores/editar/","",$ruta));
        break;
    case (strpos($ruta,"admin/trabajadores/activar/") === 0):
        controlador("trabajadores")->activar(str_replace("admin/trabajadores/activar/","",$ruta));
        break;
    case (strpos($ruta,"admin/trabajadores/borrar/") === 0)://confirmacion para borrar
        controlador("trabajadores")->borrar(str_replace("admin/trabajadores/borrar/","",$ruta));
        break;
    //Componentes
    case "admin/componentes":
        controlador("componentes")->index();
        break;
    case "admin/componentes/crear":
        controlador("componentes")->crear();
        break;
    case (strpos($ruta,"admin/componentes/editar/") === 0):
        controlador("componentes")->editar(str_replace("admin/componentes/editar/","",$ruta));
        break;
    case (strpos($ruta,"admin/componentes/activar/") === 0):
        controlador("componentes")->activar(str_replace("admin/componentes/activar/","",$ruta));
        break;
    case (strpos($ruta,"admin/componentes/home/") === 0):
        controlador("componentes")->home(str_replace("admin/componentes/home/","",$ruta));
        break;
    case (strpos($ruta,"admin/componentes/borrar/") === 0):
        controlador("componentes")->borrar(str_replace("admin/componentes/borrar/","",$ruta));
        break;
    //Reviews
    case "admin/reviews":
        controlador("reviews")->index();
        break;
    case "admin/reviews/crear":
        controlador("reviews")->crear();
        break;
    case (strpos($ruta,"admin/reviews/editar/") === 0):
        controlador("reviews")->editar(str_replace("admin/reviews/editar/","",$ruta));
        break;
    case (strpos($ruta,"admin/reviews/activar/") === 0):
        controlador("reviews")->activar(str_replace("admin/reviews/activar/","",$ruta));
        break;
    case (strpos($ruta,"admin/reviews/home/") === 0):
        controlador("reviews")->home(str_replace("admin/reviews/home/","",$ruta));
        break;
    case (strpos($ruta,"admin/reviews/borrar/") === 0):
        controlador("reviews")->borrar(str_replace("admin/reviews/borrar/","",$ruta));
        break;
    //Discusiones
    case "admin/discusiones":
        controlador("discusiones")->index();
        break;
    case "admin/discusiones/crear":
        controlador("discusiones")->crear();
        break;

    //Resto de rutas
    default:
        controlador()->index();

}