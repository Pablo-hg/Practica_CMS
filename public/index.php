<?php
namespace App;

//Inicializo sesión para poder traspasar variables entre páginas
session_start();

//Incluyo los controladores que voy a utilizar para que seran cargados por Autoload
use App\Controller\AppController;
use App\Controller\ComponentesController;
use App\Controller\TrabajadorController;
use App\Controller\DiscusionesController;

//echo password_hash("1234Abcd!",  PASSWORD_BCRYPT, ['cost'=>12]); //-->para añadir usuarios


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
        case "componentes": return new ComponentesController; //Back-end noticias
        case "usuarios": return new TrabajadorController; //Autentificacion y Back-end de usuarios
        case "discusiones": return new DiscusionController;
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
        controlador()->componente(str_replace("componente/","",$ruta)); //El parámetro es lo que hayo después de "noticias"
        break;
    case "reviews":
        controlador()->reviews();
        break;
    case (strpos($ruta,"review/") === 0): //Si la ruta empieza por "noticia/"
        controlador()->componente(str_replace("review/","",$ruta)); //El parámetro es lo que hayo después de "noticias"
        break;
    case "foro":
        controlador()->discusiones();
        break;
    case (strpos($ruta,"hilo/") === 0): //Si la ruta empieza por "noticia/"
        controlador()->discusion(str_replace("hilo/","",$ruta)); //El parámetro es lo que hayo después de "noticias"
        break;

    //Back-end
    //General
    case "admin":
    case "admin/entrar":
        controlador("usuarios")->entrar();
        break;
    case "admin/salir":
        controlador("usuarios")->salir();
        break;
    case "admin/usuarios"://listar usuarios
        controlador("usuarios")->index();
        break;
    //Usuarios
    case "admin/usuarios/crear":
        controlador("usuarios")->crear();
        break;
    case (strpos($ruta,"admin/usuarios/editar/") === 0)://editar el usuario
        controlador("usuarios")->editar(str_replace("admin/usuarios/editar/","",$ruta));
        break;
    case (strpos($ruta,"admin/usuarios/activar/") === 0):
        controlador("usuarios")->activar(str_replace("admin/usuarios/activar/","",$ruta));
        break;
    case (strpos($ruta,"admin/usuarios/borrar/") === 0)://confirmacion para borrar
        controlador("usuarios")->borrar(str_replace("admin/usuarios/borrar/","",$ruta));
        break;
    //Noticias
    case "admin/noticias":
        controlador("noticias")->index();
        break;
    case "admin/noticias/crear":
        controlador("noticias")->crear();
        break;
    case (strpos($ruta,"admin/noticias/editar/") === 0):
        controlador("noticias")->editar(str_replace("admin/noticias/editar/","",$ruta));
        break;
    case (strpos($ruta,"admin/noticias/activar/") === 0):
        controlador("noticias")->activar(str_replace("admin/noticias/activar/","",$ruta));
        break;
    case (strpos($ruta,"admin/noticias/home/") === 0):
        controlador("noticias")->home(str_replace("admin/noticias/home/","",$ruta));
        break;
    case (strpos($ruta,"admin/noticias/borrar/") === 0):
        controlador("noticias")->borrar(str_replace("admin/noticias/borrar/","",$ruta));
        break;
    case (strpos($ruta,"admin/") === 0):
        controlador("usuarios")->entrar();
        break;
    //DiscusionesController
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