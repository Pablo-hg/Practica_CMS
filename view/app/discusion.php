<div class="hilo">
    <div class="cajita">

        <aside>
            <img src="<?php echo $_SESSION['public']."img/".$datos->imagen ?>" alt="perfil" class="circle">
            <b style="color: #7badd6"><?php echo $datos->autor ?></b>
            <div class="fecha">
                <div class="material-icons" >calendar_month</div>
                <span><?php echo date("d/m/Y", strtotime($datos->fecha)) ?></span>
            </div>
            <div class="likes">
                <div class="material-icons" >favorite_border</div>
                <span><?php echo $datos->likes ?></span>
            </div>
        </aside>
        <article>
            <h1>hola</h1>
        </article>


    </div>
</div>
