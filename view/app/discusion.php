<div class="hilo">
    <?php foreach ($datos as $row){ ?>
    <div class="cajita">
        <aside>
            <img src="<?php echo $_SESSION['public']."img/".$row->image ?>" alt="perfil" class="circle">
            <b style="color: #7badd6"><?php echo $row->author ?></b>
            <div class="fecha">
                <div class="material-icons" >calendar_month</div>
                <span><?php echo date("d/m/Y", strtotime($row->dates)) ?></span>
            </div>
            <div class="likes">
                <div class="material-icons" >favorite_border</div>
                <span><?php echo $row->likes ?></span>
            </div>
        </aside>
        <article>
            <h1><?php echo $row->title ?> </h1>
            <h2><?php echo $row->intro ?></h2>
            <!--<img src="<?php echo $_SESSION['public']."img/".$row->image ?>" alt="foto hilo">-->
            <?php echo $row->texts ?>
        </article>
    </div>
    <?php } if (!isset($_SESSION['usuario'])){ ?>
            <div class="btn waves-effect waves-light" style="margin-left: 28%">
               Hay que estar conectado o registrado para responder aquí.
    <?php } else { ?>
        <button class="btn waves-effect waves-light" type="submit" name="guardar" style="margin: 35px 42.5%;" >Responder
            <i class="material-icons right">reply</i>
        </button>
    <?php }  ?>
</div>
