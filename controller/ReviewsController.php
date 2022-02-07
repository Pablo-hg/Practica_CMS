<?php

namespace App\Controller;

use App\Helper\ViewHelper;
use App\Helper\DbHelper;
use App\Model\Componentes;

class ReviewsController
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

    //Listado de reviews
    public function index(){
        //Permisos
        $this->view->permisos("componentes");

        //Recojo las componentes de la base de datos
        $rowset = $this->db->query("SELECT * FROM Componentes WHERE review=1 ORDER BY fecha DESC");


        //Asigno resultados a un array de instancias del modelo
        $reviews = array();
        while ($row = $rowset->fetch(\PDO::FETCH_OBJ)){
            array_push($reviews,new Componentes($row));
        }

        $this->view->vista("admin","reviews/index", $reviews);
    }


    //Para activar o desactivar en admin
    public function activar($id){

        //Permisos
        $this->view->permisos("componentes");

        //Obtengo el componente
        $rowset = $this->db->query("SELECT * FROM Componentes WHERE id='$id' LIMIT 1");

        $row = $rowset->fetch(\PDO::FETCH_OBJ);
        $review = new Componentes($row);

        if ($review->activo == 1){
            echo "hola";
            //Desactivo la noticia
            $consulta = $this->db->exec("UPDATE Componentes SET activo=0 WHERE id='$id'");

            //Mensaje y redirección
            ($consulta > 0) ? //Compruebo consulta para ver que no ha habido errores
                $this->view->redireccionConMensaje("admin/reviews","#0277bd light-blue darken-3","La review '<strong>$review->titulo</strong>' se ha desactivado correctamente.") :
                $this->view->redireccionConMensaje("admin/reviews","#ef5350 red lighten-1","Hubo un error al guardar en la base de datos.");
        }

        else{
            //Activo la review
            $consulta = $this->db->exec("UPDATE Componentes SET activo=1 WHERE id='$id'");

            //Mensaje y redirección
            ($consulta > 0) ? //Compruebo consulta para ver que no ha habido errores
                $this->view->redireccionConMensaje("admin/reviews","#0277bd light-blue darken-3","La review '<strong>$review->titulo</strong>' se ha activado correctamente.") :
                $this->view->redireccionConMensaje("admin/reviews","#ef5350 red lighten-1","Hubo un error al guardar en la base de datos.");
        }

    }

    //Para mostrar o no en la home
    public function home($id){

        //Permisos
        $this->view->permisos("componentes");

        //Obtengo la ewview
        $rowset = $this->db->query("SELECT * FROM Componentes WHERE id='$id' LIMIT 1");
        $row = $rowset->fetch(\PDO::FETCH_OBJ);
        $review = new Componentes($row);

        if ($review->home == 1){

            //Quito la review de la home
            $consulta = $this->db->exec("UPDATE Componentes SET home=0 WHERE id='$id'");

            //Mensaje y redirección
            ($consulta > 0) ? //Compruebo consulta para ver que no ha habido errores
                $this->view->redireccionConMensaje("admin/reviews","#0277bd light-blue darken-3","La review '<strong>$review->titulo</strong>' ya no se muestra en la home.") :
                $this->view->redireccionConMensaje("admin/reviews","#ef5350 red lighten-1","Hubo un error al guardar en la base de datos.");
        }

        else{

            //Muestro la review en la home
            $consulta = $this->db->exec("UPDATE Componentes SET home=1 WHERE id='$id'");

            //Mensaje y redirección
            ($consulta > 0) ? //Compruebo consulta para ver que no ha habido errores
                $this->view->redireccionConMensaje("admin/reviews","#0277bd light-blue darken-3","La review '<strong>$review->titulo</strong>' ahora se muestra en la home.") :
                $this->view->redireccionConMensaje("admin/reviews","#ef5350 red lighten-1","Hubo un error al guardar en la base de datos.");
        }

    }


    //Para borrar una review
    public function borrar($id){

        //Permisos
        $this->view->permisos("componentes");

        //Obtengo la review
        $rowset = $this->db->query("SELECT * FROM Componentes WHERE id='$id' LIMIT 1");
        $row = $rowset->fetch(\PDO::FETCH_OBJ);
        $review = new Componentes($row);

        //Borro la review
        $consulta = $this->db->exec("DELETE FROM Componentes WHERE id='$id'");

        //Borro la imagen asociada
        $archivo = $_SESSION['public']."img/".$review->imagen;
        $texto_imagen = "";
        if (is_file($archivo)){
            unlink($archivo);
            $texto_imagen = " y se ha borrado la imagen asociada";
        }

        //Mensaje y redirección
        ($consulta > 0) ? //Compruebo consulta para ver que no ha habido errores
            $this->view->redireccionConMensaje("admin/reviews","#0277bd light-blue darken-3","La review se ha borrado correctamente$texto_imagen.") :
            $this->view->redireccionConMensaje("admin/reviews","#ef5350 red lighten-1","Hubo un error al guardar en la base de datos.");

    }

    public function crear(){

        //Permisos
        $this->view->permisos("componentes");
        //Creo un nuevo usuario vacío
        $review = new Componentes();
        //Llamo a la ventana de edición
        $this->view->vista("admin","reviews/editar", $review);
    }

    public function editar($id){

        //Permisos
        $this->view->permisos("componentes");

        //Si ha pulsado el botón de guardar
        if (isset($_POST["guardar"])){

            //Recupero los datos del formulario
            $titulo = filter_input(INPUT_POST, "titulo", FILTER_SANITIZE_STRING);
            $entradilla = filter_input(INPUT_POST, "entradilla", FILTER_SANITIZE_STRING);
            $autor = filter_input(INPUT_POST, "autor", FILTER_SANITIZE_STRING);
            $fecha = filter_input(INPUT_POST, "fecha", FILTER_SANITIZE_STRING);
            $texto = filter_input(INPUT_POST, "texto", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            //Formato de fecha para SQL
            $fecha = \DateTime::createFromFormat("d-m-Y", $fecha)->format("Y-m-d H:i:s");

            //Genero slug (url amigable)
            $slug = $this->view->getSlug($titulo);

            //Imagen
            $imagen_recibida = $_FILES['imagen'];
            $imagen = ($_FILES['imagen']['name']) ? $_FILES['imagen']['name'] : "";
            $imagen_subida = ($_FILES['imagen']['name']) ? '/var/www/html'.$_SESSION['public']."img/".$_FILES['imagen']['name'] : "";
            $texto_img = ""; //Para el mensaje

            if ($id == "nuevo"){
                //Creo una nueva review
                $consulta = $this->db->exec("INSERT INTO Componentes 
                    (titulo, entradilla, autor, fecha, texto, slug, imagen,review) VALUES 
                    ('$titulo','$entradilla','$autor','$fecha','$texto','$slug','$imagen',1)");

                //Subo la imagen
                if ($imagen){
                    if (is_uploaded_file($imagen_recibida['tmp_name']) && move_uploaded_file($imagen_recibida['tmp_name'], $imagen_subida)){
                        $texto_img = " La imagen se ha subido correctamente.";
                    }
                    else{
                        $texto_img = " Hubo un problema al subir la imagen.";
                    }
                }

                //Mensaje y redirección
                ($consulta > 0) ?
                    $this->view->redireccionConMensaje("admin/reviews","#0277bd light-blue darken-3","La review '<strong>$titulo</strong>' se creado correctamente.".$texto_img) :
                    $this->view->redireccionConMensaje("admin/reviews","#ef5350 red lighten-1","Hubo un error al guardar en la base de datos.");
            }
            else{

                //Actualizo la review
                $this->db->exec("UPDATE Componentes SET 
                    titulo='$titulo',entradilla='$entradilla',autor='$autor',
                    fecha='$fecha',texto='$texto',slug='$slug' WHERE id='$id'");

                //Subo y actualizo la imagen
                if ($imagen){
                    if (is_uploaded_file($imagen_recibida['tmp_name']) && move_uploaded_file($imagen_recibida['tmp_name'], $imagen_subida)){
                        $texto_img = " La imagen se ha subido correctamente.";
                        $this->db->exec("UPDATE Componentes SET imagen='$imagen' WHERE id='$id'");
                    }
                    else{
                        $texto_img = " Hubo un problema al subir la imagen.";
                    }
                }

                //Mensaje y redirección
                $this->view->redireccionConMensaje("admin/reviews","#0277bd light-blue darken-3","LA review '<strong>$titulo</strong>' se guardado correctamente.".$texto_img);

            }
        }

        //Si no, obtengo el componente y muestro la ventana de edición
        else{

            //Obtengo la review
            $rowset = $this->db->query("SELECT * FROM Componentes WHERE id='$id' LIMIT 1");
            $row = $rowset->fetch(\PDO::FETCH_OBJ);
            $review = new Componentes($row);

            //Llamo a la ventana de edición
            $this->view->vista("admin","reviews/editar", $review);
        }

    }

}
