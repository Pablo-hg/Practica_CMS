<?php

namespace App\Model;

class Discusiones
{
    var $id;
    var $title;
    var $slug;
    var $intro;
    var $texts;
    var $activo;
    var $dates;
    var $author;
    var $image;
    var $likes;
    var $foro;

    function __construct($data=null){

        $this->id = ($data) ? $data->id : null;
        $this->title = ($data) ? $data->title : null;
        $this->slug = ($data) ? $data->slug : null;
        $this->intro = ($data) ? $data->intro : null;
        $this->texts = ($data) ? $data->texts : null;
        $this->activo = ($data) ? $data->activo : null;
        $this->dates = ($data) ? $data->dates : null;
        $this->author = ($data) ? $data->author : null;
        $this->image = ($data) ? $data->image : null;
        $this->likes = ($data) ? $data->likes : null;
        $this->foro = ($data) ? $data->foro : null;

    }


}