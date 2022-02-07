<?php
namespace App\Controller;

use App\Helper\ViewHelper;
use App\Helper\DbHelper;
use App\Model\Trabajadores;


class TrabajadorController
{
    var $db;
    var $view;

    function __construct()
    {
        //Conexión a la BBDD
        $dbHelper = new DbHelper();
        $this->db = $dbHelper->db;

        //Instancio el ViewHelper
        $viewHelper = new ViewHelper();
        $this->view = $viewHelper;
    }

    public function admin(){

        //Compruebo permisos
        $this->view->permisos();

        //LLamo a la vista
        $this->view->vista("admin","index");

    }

    public function entrar(){

        //Si ya está autenticado, le llevo a la página de inicio del panel
        if (isset($_SESSION['usuario'])){
            $this->admin();
        }
        //Si ha pulsado el botón de acceder, tramito el formulario
        else if (isset($_POST["acceder"])){
            //Recupero los datos del formulario
            $campo_usuario = filter_input(INPUT_POST, "usuario", FILTER_SANITIZE_STRING);
            $campo_clave = filter_input(INPUT_POST, "clave", FILTER_SANITIZE_STRING);

            //Busco al usuario en la base de datos y si está activo
            $rowset = $this->db->query("SELECT * FROM Trabajadores WHERE usuario='$campo_usuario' AND activo=1 LIMIT 1");

            //Asigno resultado a una instancia del modelo
            $row = $rowset->fetch(\PDO::FETCH_OBJ);
            $trabajador = new Trabajadores($row);

            //Si existe el usuario
            if ($trabajador->usuario){
                //Compruebo la clave
                if (password_verify($campo_clave,$trabajador->clave)) {
                    //Asigno el usuario y los permisos la sesión
                    $_SESSION["usuario"] = $trabajador->usuario;
                    $_SESSION["trabajadores"] = $trabajador->trabajadores;
                    $_SESSION["componentes"] = $trabajador->componentes;
                    $_SESSION["reviews"] = $trabajador->reviews;
                    $_SESSION["discusiones"] = $trabajador->discusiones;
                    $_SESSION["hilo"] = $trabajador->hilo;
                    $_SESSION["foto"] = $trabajador->foto;
                    echo "hola".$_SESSION["foto"];

                    //Guardo la fecha de último acceso
                    $ahora = new \DateTime("now", new \DateTimeZone("Europe/Madrid"));
                    $fecha = $ahora->format("Y-m-d H:i:s");
                    $this->db->exec("UPDATE Trabajadores SET fecha_acceso='$fecha' WHERE usuario='$campo_usuario'");

                    //Redirección con mensaje
                    //echo "acceso correcto";
                    $this->view->redireccionConMensaje("admin","#0277bd light-blue darken-3","Bienvenido al panel de administración.");

                }
                else{
                    //echo "acceso incorrecto";
                    //Redirección con mensaje
                    $this->view->redireccionConMensaje("admin","#ef5350 red lighten-1","Contraseña incorrecta.");
                }
            }
            else{
                //Redirección con mensaje
                $this->view->redireccionConMensaje("admin","#ef5350 red lighten-1","No existe ningún usuario con ese nombre.");
            }
        }
        //Le llevo a la página de acceso
        else{
            $this->view->vista("admin","trabajadores/entrar");
        }

    }

    public function salir(){

        //Borro al usuario de la sesión
        unset($_SESSION['usuario']);

        //Redirección con mensaje
        $this->view->redireccionConMensaje("admin","green","Te has desconectado con éxito.");

    }

    //Listado de trabajadores
    public function index(){

        //Permisos
        $this->view->permisos("trabajadores");

        //Recojo los trabajadores de la base de datos
        $rowset = $this->db->query("SELECT * FROM Trabajadores ORDER BY usuario ASC");

        //Asigno resultados a un array de instancias del modelo
        $usuarios = array();
        while ($row = $rowset->fetch(\PDO::FETCH_OBJ)){
            array_push($usuarios,new Trabajadores($row));
        }

        $this->view->vista("admin","trabajadores/index", $usuarios);

    }

    //Para activar o desactivar
    public function activar($id){

        //Permisos
        $this->view->permisos("trabajadores");

        //Obtengo el usuario
        $rowset = $this->db->query("SELECT * FROM Trabajadores WHERE id='$id' LIMIT 1");
        $row = $rowset->fetch(\PDO::FETCH_OBJ);
        $trabajador = new Trabajadores($row);

        if ($trabajador->activo == 1){

            //Desactivo el usuario
            $consulta = $this->db->exec("UPDATE Trabajadores SET activo=0 WHERE id='$id'");

            //Mensaje y redirección
            ($consulta > 0) ? //Compruebo consulta para ver que no ha habido errores
                $this->view->redireccionConMensaje("admin/trabajadores","#0277bd light-blue darken-3","El trabajador '<strong>$trabajador->usuario</strong>' se ha desactivado correctamente.") :
                $this->view->redireccionConMensaje("admin/trabajadores","#ef5350 red lighten-1","Hubo un error al guardar en la base de datos.");
        }

        else{

            //Activo el usuario
            $consulta = $this->db->exec("UPDATE Trabajadores SET activo=1 WHERE id='$id'");

            //Mensaje y redirección
            ($consulta > 0) ? //Compruebo consulta para ver que no ha habido errores
                $this->view->redireccionConMensaje("admin/trabajadores","#0277bd light-blue darken-3","El trabajador '<strong>$trabajador->usuario</strong>' se ha activado correctamente.") :
                $this->view->redireccionConMensaje("admin/trabajadores","#ef5350 red lighten-1","Hubo un error al guardar en la base de datos.");
        }

    }

    public function borrar($id){

        //Permisos
        $this->view->permisos("trabajadores");

        //Borro el usuario
        $consulta = $this->db->exec("DELETE FROM Trabajadores WHERE id='$id'");

        //Mensaje y redirección
        ($consulta > 0) ? //Compruebo consulta para ver que no ha habido errores
            $this->view->redireccionConMensaje("admin/trabajadores","#0277bd light-blue darken-3","El trabajador  se ha borrado correctamente.") :
            $this->view->redireccionConMensaje("admin/trabajadores","#ef5350 red lighten-1","Hubo un error al guardar en la base de datos.");

    }

    public function crear(){

        //Permisos
        $this->view->permisos("trabajadores");

        //Creo un nuevo usuario vacío
        $trabajador = new Trabajadores();

        //Llamo a la ventana de edición
        $this->view->vista("admin","trabajadores/editar", $trabajador);

    }

    public function editar($id){

        //Permisos
        $this->view->permisos("trabajadores");

        //Si ha pulsado el botón de guardar
        if (isset($_POST["guardar"])){

            //Recupero los datos del formulario
            $usuario = filter_input(INPUT_POST, "usuario", FILTER_SANITIZE_STRING);
            $clave = filter_input(INPUT_POST, "clave", FILTER_SANITIZE_STRING);
            $componentes = (filter_input(INPUT_POST, 'componentes', FILTER_SANITIZE_STRING) == 'on') ? 1 : 0;
            $reviews = (filter_input(INPUT_POST, 'reviews', FILTER_SANITIZE_STRING) == 'on') ? 1 : 0;
            $cambiar_clave = (filter_input(INPUT_POST, 'cambiar_clave', FILTER_SANITIZE_STRING) == 'on') ? 1 : 0;
            $discusiones = (filter_input(INPUT_POST, 'discusiones', FILTER_SANITIZE_STRING) == 'on') ? 1 : 0;
            $hilo = (filter_input(INPUT_POST, 'hilo', FILTER_SANITIZE_STRING) == 'on') ? 1 : 0;
            $trabajadores = (filter_input(INPUT_POST, 'trabajadores', FILTER_SANITIZE_STRING) == 'on') ? 1 : 0;

            //Encripto la clave
            $clave_encriptada = ($clave) ? password_hash($clave,  PASSWORD_BCRYPT, ['cost'=>12]) : "";

            //Imagen
            $imagen_recibida = $_FILES['imagenperfil'];
            $imagen = ($_FILES['imagenperfil']['name']) ? $_FILES['imagenperfil']['name'] : "";
            $imagen_subida = ($_FILES['imagenperfil']['name']) ? '/var/www/html'.$_SESSION['public']."img/".$_FILES['imagenperfil']['name'] : "";
            $texto_img = ""; //Para el mensaje

            if ($id == "nuevo"){
                //Creo un nuevo usuario
                $consulta =$this->db->exec("INSERT INTO Trabajadores
                    (usuario, clave, componentes, reviews, discusiones, hilo,
                     trabajadores,foto) VALUES ('$usuario','$clave_encriptada','$componentes','$reviews','$discusiones',
                     '$hilo','$trabajadores','$imagen')");
                //Subo la imagen
                if ($imagen){
                    if (is_uploaded_file($imagen_recibida['tmp_name']) && move_uploaded_file($imagen_recibida['tmp_name'], $imagen_subida)){
                        $texto_img = " La imagen se ha subido correctamente.";
                    }
                    else {
                        $texto_img = "Hubo un problema al subir la imagen.";
                    }
                }

                //Mensaje y redirección
                ($consulta > 0) ?
                    $this->view->redireccionConMensaje("admin/trabajadores","#0277bd light-blue darken-3","El trabajador '<strong>$usuario</strong>' se creado correctamente.$texto_img") :
                    $this->view->redireccionConMensaje("admin/trabajadores","#ef5350 red lighten-1","Hubo un error al guardar en la base de datos.");
            }
            else{
                //Actualizo el usuario
                ($cambiar_clave) ?
                    $this->db->exec("UPDATE Trabajadores SET 
                        usuario='$usuario',clave='$clave_encriptada',componentes='$componentes',reviews='$reviews',
                        discusiones='$discusiones',hilo='$hilo',trabajadores='$trabajadores' WHERE id='$id'") :
                    $this->db->exec("UPDATE Trabajadores SET usuario='$usuario',componentes='$componentes',reviews='$reviews',
                        discusiones='$discusiones',hilo='$hilo',trabajadores='$trabajadores' WHERE id='$id'");

                //Subo y actualizo la imagen
                if ($imagen){
                    if (is_uploaded_file($imagen_recibida['tmp_name']) && move_uploaded_file($imagen_recibida['tmp_name'], $imagen_subida)){
                        $texto_img = " La imagen se ha subido correctamente.";
                        $this->db->exec("UPDATE Trabajadores SET foto='$imagen' WHERE id='$id'");
                    }
                    else{
                        $texto_img = " Hubo un problema al subir la imagen.";
                    }
                }

                //Mensaje y redirección
                $this->view->redireccionConMensaje("admin/trabajadores","#0277bd light-blue darken-3","El trabajador '<strong>$usuario</strong>' se actualizado correctamente.$texto_img");
            }
        }

        //Si no, obtengo usuario y muestro la ventana de edición
        else{

            //Obtengo el usuario
            $rowset = $this->db->query("SELECT * FROM Trabajadores WHERE id='$id' LIMIT 1");
            $row = $rowset->fetch(\PDO::FETCH_OBJ);
            $trabajador = new Trabajadores($row);

            //Llamo a la ventana de edición
            $this->view->vista("admin","trabajadores/editar", $trabajador);
        }

    }


}
