<h3>
    <?php if ($datos->id){ ?>
        <span>Editar <?php echo $datos->usuario ?></span>
    <?php } else { ?>
        <span>Nuevo trabajador</span>
    <?php } ?>
</h3>
<div class="row">
    <?php $id = ($datos->id) ? $datos->id : "nuevo" ?>
    <form class="col s12" method="POST" action="<?php echo $_SESSION['home'] ?>admin/trabajadores/editar/<?php echo $id ?>">
        <div class="col m12 16">
            <div class="row">
                <div class="input-field col s12">
                    <input id="usuario" type="text" name="usuario" value="<?php echo $datos->usuario ?>">
                    <label for="usuario">Trabajador</label>
                </div>
                <?php $clase = ($datos->id) ? "hide" : "" ?>
                <div class="input-field col s12 <?php echo $clase ?>" id="password">
                    <input id="clave" type="password" name="clave" value="">
                    <label for="clave">Contraseña</label>
                </div>
                <?php $clase = ($datos->id) ? "" : "hide" ?>
                <p class="<?php echo $clase ?>">
                    <label for="cambiar_clave">
                        <input id="cambiar_clave" name="cambiar_clave" type="checkbox">
                        <span>Pulsa para cambiar la clave</span>
                    </label>
                </p>
            </div>
        </div>
        <div class="col m12 l6 center-align">
            <div class="file-field input-field">
                <div class="btn">
                    <span>Imagen</span>
                    <input type="file" name="imagenperfil">
                </div>
                <div class="file-path-wrapper">
                    <input class="file-path validate" type="text">
                </div>
            </div>
            <?php if ($datos->foto){ ?>
                <img src="<?php echo $_SESSION['public']."img/".$datos->foto ?>" alt="<?php echo $datos->titulo ?>" style="width: 265px">
            <?php } ?>
        </div>
        <div class="col s12">
            <div class="row">
                <p>Permisos</p>
                <p>
                    <label for="componentes" >
                        <input id="componentes" name="componentes" type="checkbox" <?php echo ($datos->componentes == 1) ? "checked" : "" ?>>
                        <span>Componentes</span>
                    </label>
                    <label for="reviews" style="margin-left: 100px">
                        <input id="reviews" name="reviews" type="checkbox" <?php echo ($datos->reviews == 1) ? "checked" : "" ?>>
                        <span>Reviews</span>
                    </label>
                </p>
                <p>
                    <label for="discusiones">
                        <input id="discusiones" name="discusiones" type="checkbox" <?php echo ($datos->discusiones == 1) ? "checked" : "" ?>>
                        <span>Discusiones</span>
                    </label>
                    <label for="hilo" style="margin-left: 115px">
                        <input id="hilo" name="hilo" type="checkbox" <?php echo ($datos->hilo == 1) ? "checked" : "" ?>>
                        <span>Hilo</span>
                    </label>
                </p>
                <p>
                    <label for="trabajadores">
                        <input id="trabajadores" name="trabajadores" type="checkbox" <?php echo ($datos->trabajadores == 1) ? "checked" : "" ?>>
                        <span>Trabajadores</span>
                    </label>
                </p>
                <?php $clase = ($datos->id) ? "" : "hide" ?>
                <p class="<?php echo $clase ?>">
                    Último acceso: <strong><?php echo date("d/m/Y H:i", strtotime($datos->fecha_acceso)) ?></strong>
                </p>
            </div>
            <div class="input-field col s12">
                <a href="<?php echo $_SESSION['home'] ?>admin/trabajadores" title="Volver">
                    <button class="btn waves-effect waves-light" type="button">Volver
                        <i class="material-icons right">replay</i>
                    </button>
                </a>
                <button class="btn waves-effect waves-light" type="submit" name="guardar">Guardar
                    <i class="material-icons right">save</i>
                </button>
            </div>
        </div>
    </form>
</div>
