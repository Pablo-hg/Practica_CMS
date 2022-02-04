<?php

namespace App\Controller;

use App\Helper\ViewHelper;
use App\Helper\DbHelper;
use App\Model\Componentes;


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

        //Recojo las componentes de la base de datos
        $rowset = $this->db->query("SELECT * FROM Discusiones ORDER BY fecha DESC");

        //Asigno resultados a un array de instancias del modelo
        $discusiones = array();
        while ($row = $rowset->fetch(\PDO::FETCH_OBJ)){
            array_push($discusiones,new Componentes($row));
        }

        $this->view->vista("admin","componentes/index", $discusiones);

    }

    //Para activar o desactivar en admin
    public function activar($id){

        //Permisos
        $this->view->permisos("discusiones");

        //Obtengo la noticia
        $rowset = $this->db->query("SELECT * FROM Discusiones WHERE id='$id' LIMIT 1");
        $row = $rowset->fetch(\PDO::FETCH_OBJ);
        $discusion = new Discusion($row);

        if ($discusion->activo == 1){

            //Desactivo la noticia
            $consulta = $this->db->exec("UPDATE Discusiones SET activo=0 WHERE id='$id'");

            //Mensaje y redirección
            ($consulta > 0) ? //Compruebo consulta para ver que no ha habido errores
                $this->view->redireccionConMensaje("admin/discusiones","green","El componentes <strong>$discusion->titulo</strong> se ha desactivado correctamente.") :
                $this->view->redireccionConMensaje("admin/discusiones","red","Hubo un error al guardar en la base de datos.");
        }

        else{
            //Activo la noticia
            $consulta = $this->db->exec("UPDATE Discusiones SET activo=1 WHERE id='$id'");

            //Mensaje y redirección
            ($consulta > 0) ? //Compruebo consulta para ver que no ha habido errores
                $this->view->redireccionConMensaje("admin/discusiones","green","El componente <strong>$discusion->titulo</strong> se ha activado correctamente.") :
                $this->view->redireccionConMensaje("admin/discusiones","red","Hubo un error al guardar en la base de datos.");
        }

    }

    public function borrar($id){

        //Permisos
        $this->view->permisos("discusiones");

        //Obtengo la noticia
        $rowset = $this->db->query("SELECT * FROM Discusiones WHERE id='$id' LIMIT 1");
        $row = $rowset->fetch(\PDO::FETCH_OBJ);
        $discusion = new Discusiones($row);

        //Borro la noticia
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
            $this->view->redireccionConMensaje("admin/discusiones","green","La noticia se ha borrado correctamente$texto_imagen.") :
            $this->view->redireccionConMensaje("admin/discusiones","red","Hubo un error al guardar en la base de datos.");

    }

}