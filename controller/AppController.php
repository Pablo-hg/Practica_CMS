<?php
namespace App\Controller;

use App\Model\Componentes;
use App\Helper\ViewHelper;
use App\Helper\DbHelper;
use App\Model\Discusiones;


class AppController
{
    var $db;
    var $view;

    //Constructor
    function __construct()
    {
        //Conexión a la BBDD
        $dbHelper = new DbHelper();
        $this->db = $dbHelper->db;

        //Instancio el ViewHelper
        $viewHelper = new ViewHelper();
        $this->view = $viewHelper;
    }

    //Home
    public function index(){
        //Consulta a la bbdd
        $rowset = $this->db->query("SELECT * FROM Componentes WHERE activo=1 AND home=1 ORDER BY fecha DESC");
        //Asigno resultados a un array de instancias del modelo
        $componentes = array();
        while ($row = $rowset->fetch(\PDO::FETCH_OBJ)){
            array_push($componentes,new Componentes($row));
        }
        //Llamo a la vista
        $this->view->vista("app", "index", $componentes);
    }

    //Acerca-de
    public function acercade(){
        //Llamo a la vista
        $this->view->vista("app", "acerca-de");
    }

    //Componentes que son reviews
    public function reviews(){
        $rowset = $this->db->query("SELECT * FROM Componentes WHERE activo=1 AND review=1 ORDER BY fecha DESC");
        $reviews = array();
        while ($row = $rowset->fetch(\PDO::FETCH_OBJ)){
            array_push($reviews,new Componentes($row));
        }
        //Llamo a la vista
        $this->view->vista("app", "componentes", $reviews);
    }

    //Componentes
    public function componentes(){
        //Consulta a la bbdd
        $rowset = $this->db->query("SELECT * FROM Componentes WHERE activo=1 AND review=0 ORDER BY fecha DESC");
        //Asigno resultados a un array de instancias del modelo
        $componentes = array();
        while ($row = $rowset->fetch(\PDO::FETCH_OBJ)){
            array_push($componentes,new Componentes($row));
        }
        //Llamo a la vista
        $this->view->vista("app", "componentes", $componentes);
    }

    //Componente
    public function componente($slug){
        //Consulta a la bbdd
        $rowset = $this->db->query("SELECT * FROM Componentes WHERE activo=1 AND slug='$slug' LIMIT 1");
        //Asigno resultado a una instancia del modelo
        $row = $rowset->fetch(\PDO::FETCH_OBJ);
        $componente = new Componentes($row);
        //Llamo a la vista
        $this->view->vista("app", "componente", $componente);
    }

    //Discusiones
    public function discusiones(){
        //Consulta a la bbdd
        $rowset = $this->db->query("SELECT * FROM Discusiones WHERE activo=1 AND foro=1 ORDER BY dates DESC");
        //Asigno resultados a un array de instancias del modelo
        $discusiones = array();
        while ($row = $rowset->fetch(\PDO::FETCH_OBJ)){
            array_push($discusiones,new Discusiones($row));
        }
        //Llamo a la vista
        $this->view->vista("app", "discusiones", $discusiones);
    }

    //Discusion
    public function discusion($slug){
        //Consulta a la bbdd
        $rowset = $this->db->query("SELECT * FROM Discusiones WHERE activo=1 AND slug='$slug'");
        //Asigno resultado a una instancia del modelo
        $hilo = array();
        while ($row = $rowset->fetch(\PDO::FETCH_OBJ)) {
            array_push($hilo, new Discusiones($row));
        }
        //Llamo a la vista
        $this->view->vista("app", "discusion", $hilo);

    }

}
