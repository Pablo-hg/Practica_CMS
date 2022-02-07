<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Práctica CMS</title>

    <!--CSS-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $_SESSION['public'] ?>css/admin.css">
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
            <?php if (!isset($_SESSION['usuario'])){ ?>
                <li class="<?php echo ($_SESSION['ruta'] == '') ? "activo" : "" ?>">
                    <a href="<?php echo $_SESSION['home'] ?>" title="Inicio"">Inicio</a>
                </li>
                <li class="<?php echo ($_SESSION['ruta'] == 'componentes') ? "activo" : "" ?>">
                    <a href="<?php echo $_SESSION['home'] ?>componentes" title="Componentes">Componentes</a>
                </li>
                <li class="<?php echo ($_SESSION['ruta'] == 'reviews') ? "activo" : "" ?>">
                    <a href="<?php echo $_SESSION['home'] ?>reviews" title="Reviews">Reviews</a>
                </li>
                <li>
                <li class="<?php echo ($_SESSION['ruta'] == 'foro') ? "activo" : "" ?>">
                    <a href="<?php echo $_SESSION['home'] ?>foro" title="Foro">Foro</a>
                </li>
                <li class="<?php echo ($_SESSION['ruta'] == 'acerca-de') ? "activo" : "" ?>">
                    <a href="<?php echo $_SESSION['home'] ?>acerca-de" title="Acerca de">Acerca de</a>
                </li>
                <li>
                    <a href="<?php echo $_SESSION['home'] ?>admin/salir" title="Panel de administración" style="background-color: #00c300;">Acceder </a>
                </li>
            <?php } else{ ?>
            <li class="<?php echo ($_SESSION['ruta'] == 'admin/inicio') ? "activoadmin" : "" ?>">
                <a href="<?php echo $_SESSION['home'] ?>admin/inicio" title="Inicio"">Inicio</a>
            </li>
            <?php if ($_SESSION['componentes'] == 1) { ?>
                <li class="<?php echo ($_SESSION['ruta'] == 'admin/componentes') ? "activoadmin" : "" ?>">
                    <a href="<?php echo $_SESSION['home'] ?>admin/componentes" title="Componentes">Componentes</a>
                </li>
            <?php } if ($_SESSION['reviews'] == 1) { ?>
                <li class="<?php echo ($_SESSION['ruta'] == 'admin/reviews') ? "activoadmin" : "" ?>">
                    <a href="<?php echo $_SESSION['home'] ?>admin/reviews" title="Reviews">Reviews</a>
                </li>
            <?php }  if ($_SESSION['discusiones'] == 1) { ?>
                <li class="<?php echo ($_SESSION['ruta'] == 'admin/discusiones') ? "activoadmin" : "" ?>">
                    <a href="<?php echo $_SESSION['home'] ?>admin/discusiones" title="discusiones">Discusiones</a>
                </li>
             <?php /*} else if (($_SESSION['discusiones'] == 0 && $_SESSION['hilo'] == 1)) { ?>
                <li class="<?php echo ($_SESSION['ruta'] == 'admin/discusiones') ? "activoadmin" : "" ?>">
                    <a href="<?php echo $_SESSION['home'] ?>admin/discusiones" title="discusiones">Discusiones</a>
                </li>
                <?php */} if ($_SESSION['trabajadores'] == 1) { ?>
                <li class="<?php echo ($_SESSION['ruta'] == 'admin/trabajadores') ? "activoadmin" : "" ?>">
                    <a href="<?php echo $_SESSION['home'] ?>admin/trabajadores" title="discusiones">Trabajadores</a>
                </li>
            <?php } ?>
            <li>
                <a href="<?php echo $_SESSION['home'] ?>admin/salir" title="Panel de administración" style="background-color: #00c300;">Salir </a>
                <?php } ?>
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


<!-- Si existen mensajes  -->
<?php if (isset($_SESSION['mensaje'])) { ?>

    <!-- Los muestro ocultos -->
    <input type="hidden" name="tipo-mensaje" value="<?php echo $_SESSION["mensaje"]['tipo'] ?>">
    <input type="hidden" name="texto-mensaje" value="<?php echo $_SESSION["mensaje"]['texto'] ?>">

    <!-- Borro mensajes -->
    <?php unset($_SESSION["mensaje"]) ?>

<?php } ?>

<main>
    <section class="container-fluid">
