<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Práctica CMS</title>

    <!--CSS-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $_SESSION['public'] ?>css/app.css">
</head>

<body>
<header>
    <!--Logo-->
    <a href="<?php echo $_SESSION['home'] ?>" class="brand-logo" title="Inicio">
        <img src="<?php echo $_SESSION['public'] ?>img/mordecai.jpeg" alt="Sporovich">
    </a>
    <img src="https://tpc.googlesyndication.com/simgad/7485003666317542473?sqp=4sqPyQQ7QjkqNxABHQAAtEIgASgBMAk4A0DwkwlYAWBfcAKAAQGIAQGdAQAAgD-oAQGwAYCt4gS4AV_FAS2ynT4&rs=AOga4qmBAkVv7zPZv10PWVURTsmejmTbiA">
</header>
<nav>
    <div class="nav-wrapper">
        <!--Botón menú móviles-->
        <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>

        <!--Menú de navegación-->
        <ul id="nav-mobile" class="center-aling left hide-on-med-and-down">
            <li class="active">
                <a href="<?php echo $_SESSION['home'] ?>" title="Inicio" style="background-color: rgba(31,110,163,.8);">Inicio</a>
            </li>
            <li>
                <a href="<?php echo $_SESSION['home'] ?>componentes" title="Componentes">Componentes</a>
            </li>
            <li>
                <a href="<?php echo $_SESSION['home'] ?>reviews" title="Reviews">Reviews</a>
            </li>
            <li>
                <a href="<?php echo $_SESSION['home'] ?>foro" title="Foro">Foro</a>
            </li>
            <li>
                <a href="<?php echo $_SESSION['home'] ?>acerca-de" title="Acerca de">Acerca de</a>
            </li>
            <li>
                <a href="<?php echo $_SESSION['home'] ?>admin" title="Panel de administración"
                   target="_blank" style="background-color: #00c300;"> Admin </a>
            </li>
        </ul>

    </div>
</nav>

<!--Menú de navegación móvil-->
<ul class="sidenav" id="mobile-demo">
    <li>
        <a href="<?php echo $_SESSION['home'] ?>" title="Inicio">Inicio</a>
    </li>
    <li>
        <a href="<?php echo $_SESSION['home'] ?>noticias" title="Noticias">Noticias</a>
    </li>
    <li>
        <a href="<?php echo $_SESSION['home'] ?>acerca-de" title="Acerca de">Acerca de</a>
    </li>
    <li>
        <a href="<?php echo $_SESSION['home'] ?>admin" title="Panel de administración"
           target="_blank" class="grey-text">
            Admin
        </a>
    </li>
</ul>
<main>
    <section class="container-fluid">
