<?php
namespace App\Model;

class Trabajadores {

    //Variables o atributos
    var $id;
    var $usuario;
    var $clave;
    var $fecha_acceso;
    var $activo;
    var $trabajadores;
    var $componentes;
    var $discusiones;
    var $hilo;
    var $reviews;

    function __construct($data=null){

        $this->id = ($data) ? $data->id : null;
        $this->usuario = ($data) ? $data->usuario : null;
        $this->clave = ($data) ? $data->clave : null;
        $this->fecha_acceso = ($data) ? $data->fecha_acceso : null;
        $this->activo = ($data) ? $data->activo : null;
        $this->trabajadores = ($data) ? $data->trabajadores : null;
        $this->componentes = ($data) ? $data->componentes : null;
        $this->discusiones = ($data) ? $data->discusiones : null;
        $this->hilo = ($data) ? $data->hilo : null;
        $this->reviews = ($data) ? $data->reviews : null;

    }

}
