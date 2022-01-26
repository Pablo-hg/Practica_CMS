<div class="hilo">
    <?php foreach ($datos as $row){ ?>
    <div class="cajita">
        <aside>
            <img src="<?php echo $_SESSION['public']."img/".$row->imagen ?>" alt="perfil" class="circle">
            <b style="color: #7badd6"><?php echo $row->autor ?></b>
            <div class="fecha">
                <div class="material-icons" >calendar_month</div>
                <span><?php echo date("d/m/Y", strtotime($row->fecha)) ?></span>
            </div>
            <div class="likes">
                <div class="material-icons" >favorite_border</div>
                <span><?php echo $row->likes ?></span>
            </div>
        </aside>
        <article>
            <h1><?php echo $row->entradilla ?> </h1>
            <h2><?php echo $row->entradilla ?></h2>
            <?php echo $row->texto ?>
        </article>
    </div>
    <?php } ?>
</div>
