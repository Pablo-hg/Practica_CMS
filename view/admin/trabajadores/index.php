<h3>
    Trabajadores
</h3>
<div class="row">
    <!--Nuevo-->
    <article class="col s12 l6">
        <div class="card horizontal admin">
            <div class="card-stacked">
                <div class="card-content">
                    <i class="grey-text material-icons medium">person</i>
                    <h4 class="grey-text">
                        nuevo usuario
                    </h4><br><br>
                </div>
                <div class="card-action">
                    <a href="<?php echo $_SESSION['home']."admin/trabajadores/crear" ?>" title="Añadir nuevo usuario">
                        <i class="material-icons">add_circle</i>
                    </a>
                </div>
            </div>
        </div>
    </article>
    <?php foreach ($datos as $row){ ?>
        <article class="col s12 l6">
            <div class="card horizontal  sticky-action admin">
                <div class="card-stacked">
                    <div class="card-content">
                        <img src="<?php echo $_SESSION['public']."img/".$row->foto ?>" alt="perfil" class="circle" style="width: 75px">
                        <h4> <?php echo $row->usuario ?></h4>
                        <strong>Componentes: </strong><?php echo ($row->componentes) ? "Sí" : "No" ?>
                        <strong>&nbsp Reviews: </strong><?php echo ($row->reviews) ? "Sí" : "No" ?>
                        <strong>&nbsp Discusiones: </strong><?php echo ($row->discusiones) ? "Sí" : "No" ?><br>
                        <strong>Hilo: </strong><?php echo ($row->hilo) ? "Sí" : "No" ?>
                        <strong>&nbsp Trabajadores: </strong><?php echo ($row->trabajadores) ? "Sí" : "No" ?>
                    </div>
                    <div class="card-action">
                        <a href="<?php echo $_SESSION['home']."admin/trabajadores/editar/".$row->id ?>" title="Editar">
                            <i class="material-icons">edit</i>
                        </a>
                        <?php $title = ($row->activo == 1) ? "Desactivar" : "Activar" ?>
                        <?php $color = ($row->activo == 1) ? "green-text" : "red-text" ?>
                        <?php $icono = ($row->activo == 1) ? "mood" : "mood_bad" ?>
                        <a href="<?php echo $_SESSION['home']."admin/trabajadores/activar/".$row->id ?>" title="<?php echo $title ?>">
                            <i class="<?php echo $color ?> material-icons"><?php echo $icono ?></i>
                        </a>
                        <a href="#" class="activator" title="Borrar">
                            <i class="material-icons">delete</i>
                        </a>
                    </div>
                </div>
                <!--Confirmación de borrar-->
                <div class="card-reveal">
                    <span class="card-title grey-text text-darken-4">Borrar usuario<i class="material-icons right">close</i></span>
                    <p>
                        ¿Está seguro de que quiere borrar al usuario<strong><?php echo $row->usuario ?></strong>?<br>
                        Esta acción no se puede deshacer.
                    </p>
                    <a href="<?php echo $_SESSION['home']."admin/trabajadores/borrar/".$row->id ?>" title="Borrar">
                        <button class="btn waves-effect waves-light" type="button">Borrar
                            <i class="material-icons right">delete</i>
                        </button>
                    </a>
                </div>
            </div>
        </article>
    <?php } ?>
</div>
