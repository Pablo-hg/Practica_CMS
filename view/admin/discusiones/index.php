<h3> Discusiones </h3>
<div class="contenido">
    <ul class="collection">
        <li class="collection-item avatar">
            <img src="<?php echo $_SESSION['public'] ?>img/defecto.png"  alt="perfil" class="circle">
            <span class="title" style="color: #9e9e9e ">
                <b>Nueva Discusión</b></span>
            <div class="secondary-content">
                <a href="<?php echo $_SESSION['home']."admin/discusiones/crear" ?>" title="Añadir nueva discusion">
                    <i class="material-icons">add_circle</i>
                </a>
            </div>
        </li>
        <?php foreach ($datos as $row){ ?>
        <li class="collection-item avatar">
            <img src="<?php echo $_SESSION['public']."img/".$row->image ?>" alt="perfil" class="circle">
            <span class="title">
                 <a href="<?php echo $_SESSION['home']."admin/hilo/".$row->slug ?>">
                    <b style="color: #7badd6"> <?php echo $row->title ?> </b> </a>
            </span><br>
            <div class="datos">
                <?php echo $row->author ?> . <?php echo date("d/m/Y", strtotime($row->dates)) ?>
            </div>
            <div class="secondary-content">
                <a href="<?php echo $_SESSION['home']."admin/discusiones/editar/".$row->id ?>" title="Editar"> <i class="material-icons">edit</i></a>
                <?php $title = ($row->activo == 1) ? "Desactivar" : "Activar" ?>
                <?php $color = ($row->activo == 1) ? "green-text" : "red-text" ?>
                <?php $icono = ($row->activo == 1) ? "mood" : "mood_bad" ?>
                <a href="<?php echo $_SESSION['home']."admin/discusiones/activar/".$row->id ?>" title="<?php echo $title ?>">
                    <i class="<?php echo $color ?> material-icons"><?php echo $icono ?></i>
                </a>
                <a href="<?php echo $_SESSION['home']."admin/discusiones/borrar/".$row->id ?>" title="Borrar">
                    <button type="button" style="background-color: transparent;border-color: transparent; cursor: pointer">
                        <i class="orange-text material-icons right">delete</i>
                    </button>
                </a>
            </div>
        </li>
        <?php } ?>
    </ul>
</div>
