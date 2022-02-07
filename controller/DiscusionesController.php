<?php

namespace App\Controller;

use App\Helper\ViewHelper;
use App\Helper\DbHelper;
use App\Model\Discusiones;


class DiscusionesController
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

    //Listado de discusiones
    public function index(){

        //Permisos
        $this->view->permisos("discusiones");

        //Recojo las discusiones de la base de datos
        $rowset = $this->db->query("SELECT * FROM Discusiones WHERE foro=1 ORDER BY dates DESC");

        //Asigno resultados a un array de instancias del modelo
        $discusiones = array();
        while ($row = $rowset->fetch(\PDO::FETCH_OBJ)){
            array_push($discusiones,new Discusiones($row));
        }

        $this->view->vista("admin","discusiones/index", $discusiones);

    }

    //para crear una discusion
    public function crear(){

        //Permisos
        $this->view->permisos("discusiones");
        //Creo un nuevo usuario vacío
        $discusion = new Discusiones();
        //Llamo a la ventana de edición
        $this->view->vista("admin","discusiones/editar", $discusion);
    }


    //Para activar o desactivar en admin
    public function activar($id){

        //Permisos
        $this->view->permisos("discusiones");

        //Obtengo la noticia
        $rowset = $this->db->query("SELECT * FROM Discusiones WHERE id='$id' LIMIT 1");
        $row = $rowset->fetch(\PDO::FETCH_OBJ);
        $discusion = new Discusiones($row);

        if ($discusion->activo == 1){

            //Desactivo la noticia
            $consulta = $this->db->exec("UPDATE Discusiones SET activo=0 WHERE id='$id'");

            //Mensaje y redirección
            ($consulta > 0) ? //Compruebo consulta para ver que no ha habido errores
                $this->view->redireccionConMensaje("admin/discusiones","#0277bd light-blue darken-3","La discusión '<strong>$discusion->titulo</strong>' se ha desactivado correctamente.") :
                $this->view->redireccionConMensaje("admin/discusiones","#ef5350 red lighten-1","Hubo un error al guardar en la base de datos.");
        }

        else{
            //Activo la noticia
            $consulta = $this->db->exec("UPDATE Discusiones SET activo=1 WHERE id='$id'");

            //Mensaje y redirección
            ($consulta > 0) ? //Compruebo consulta para ver que no ha habido errores
                $this->view->redireccionConMensaje("admin/discusiones","#0277bd light-blue darken-3","La discusión '<strong>$discusion->titulo</strong>' se ha activado correctamente.") :
                $this->view->redireccionConMensaje("admin/discusiones","#ef5350 red lighten-1","Hubo un error al guardar en la base de datos.");
        }

    }

    //Para borrar una discusion
    public function borrar($id){

        //Permisos
        $this->view->permisos("discusiones");

        //Obtengo la discusion
        $rowset = $this->db->query("SELECT * FROM Discusiones WHERE id='$id' LIMIT 1");
        $row = $rowset->fetch(\PDO::FETCH_OBJ);
        $discusion = new Discusiones($row);

        //Borro la discusion
        $consulta = $this->db->exec("DELETE FROM Discusiones WHERE id='$id'");

        //Borro la imagen asociada
        $archivo = $_SESSION['public']."img/".$discusion->imagen;
        $texto_imagen = "";
        if (is_file($archivo)){
            unlink($archivo);
            $texto_imagen = " y se ha borrado la imagen asociada";
        }

        //Mensaje y redirección
        ($consulta > 0) ? //Compruebo consulta para ver que no ha habido errores
            $this->view->redireccionConMensaje("admin/discusiones","#0277bd light-blue darken-3","La noticia se ha borrado correctamente$texto_imagen.") :
            $this->view->redireccionConMensaje("admin/discusiones","ef5350 red lighten-1","Hubo un error al guardar en la base de datos.");

    }

    //Para editar una discusion
    public function editar($id){

        //Permisos
        $this->view->permisos("discusiones");

        //Si ha pulsado el botón de guardar
        if (isset($_POST["guardar"])){

            //Recupero los datos del formulario
            $title = filter_input(INPUT_POST, "title", FILTER_SANITIZE_STRING);
            $intro = filter_input(INPUT_POST, "intro", FILTER_SANITIZE_STRING);
            $author = filter_input(INPUT_POST, "author", FILTER_SANITIZE_STRING);
            $dates = filter_input(INPUT_POST, "dates", FILTER_SANITIZE_STRING);
            $texts = filter_input(INPUT_POST, "texts", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            //Formato de fecha para SQL
            $dates = \DateTime::createFromFormat("d-m-Y", $dates)->format("Y-m-d H:i:s");

            //Genero slug (url amigable)
            $slug = $this->view->getSlug($title);

            //Imagen
            $imagen_recibida = $_FILES['image'];
            $imagen = ($_FILES['image']['name']) ? $_FILES['image']['name'] : "";
            $imagen_subida = ($_FILES['image']['name']) ? '/var/www/html'.$_SESSION['public']."img/".$_FILES['image']['name'] : "";
            $texto_img = ""; //Para el mensaje

            if ($id == "nuevo"){
                //Creo una nueva discusion
                $consulta = $this->db->exec("INSERT INTO Discusiones (title, intro, author, dates,
                         texts, slug, image) VALUES ('$title','$intro','$author','$dates','$texts','$slug','$imagen')");
                //Subo la imagen
                if ($imagen){
                    if (is_uploaded_file($imagen_recibida['tmp_name']) && move_uploaded_file($imagen_recibida['tmp_name'], $imagen_subida)){
                        $texto_img = " La imagen se ha subido correctamente.";
                    }
                    else{
                        $texto_img = "Hubo un problema al subir la imagen.";
                    }
                }

                //Mensaje y redirección
                ($consulta > 0) ?
                    $this->view->redireccionConMensaje("admin/discusiones","#0277bd light-blue darken-3","La discusion '<strong>$title</strong>' se creado correctamente.$texto_img") :
                    $this->view->redireccionConMensaje("admin/discusiones","#ef5350 red lighten-1","Hubo un error al guardar en la base de datos.");
            }
            else{
                //Actualizo la discusion
                $this->db->exec("UPDATE Discusiones SET 
                    title='$title',intro='$intro',author='$author',
                    dates='$dates',texts='$texts',slug='$slug' WHERE id='$id'");

                //Subo y actualizo la imagen
                if ($imagen){
                    if (is_uploaded_file($imagen_recibida['tmp_name']) && move_uploaded_file($imagen_recibida['tmp_name'], $imagen_subida)){
                        $texto_img = " La imagen se ha subido correctamente.";
                        $this->db->exec("UPDATE Discusiones SET image='$imagen' WHERE id='$id'");
                    }
                    else{
                        $texto_img = " Hubo un problema al subir la imagen.";
                    }
                }

                //Mensaje y redirección
                $this->view->redireccionConMensaje("admin/discusiones","#0277bd light-blue darken-3","La discusion '<strong>$title</strong>' se guardado correctamente.".$texto_img);

            }
        }

        //Si no, obtengo la discusion y muestro la ventana de edición
        else{

            //Obtengo la discusion
            $rowset = $this->db->query("SELECT * FROM Discusiones WHERE id='$id' LIMIT 1");
            $row = $rowset->fetch(\PDO::FETCH_OBJ);
            $discusion = new Discusiones($row);

            //Llamo a la ventana de edición
            $this->view->vista("admin","discusiones/editar", $discusion);
        }

    }

    //Ver los hilos/una discusion
    public function discusion($slug){

        //Permisos
        $this->view->permisos("discusiones");

        if (isset($_POST["responder"])){
            echo "hola";
        }

        //Consulta a la bbdd
        $rowset = $this->db->query("SELECT * FROM Discusiones WHERE activo=1 AND slug='$slug'");

        $hilo = array();
        while ($row = $rowset->fetch(\PDO::FETCH_OBJ)){
            array_push($hilo,new Discusiones($row));
        }
        //Llamo a la vista
        $this->view->vista("admin", "discusiones/hilo", $hilo);


    }


}