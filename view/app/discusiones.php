<h1> Discusiones </h1>
<div class="contenido">
    <ul class="collection">
        <?php foreach ($datos as $row){ ?>
        <li class="collection-item avatar">
            <img src="<?php echo $_SESSION['public']."img/".$row->image ?>" alt="perfil" class="circle">
            <span class="title">
                 <a href="<?php echo $_SESSION['home']."hilo/".$row->slug ?>">
                    <b style="color: #7badd6"> <?php echo $row->title ?> </b> </a>
            </span><br>
            <div class="datos">
                <?php echo $row->author ?> &nbsp <?php echo date("d/m/Y", strtotime($row->dates)) ?>
            </div>
            <div class="secondary-content" style="color: #7badd6">
                <div class="material-icons" >favorite_border</div>
                <span class="numlikes"><?php echo $row->likes ?></span>
            </div>
        </li>
        <?php } if (!isset($_SESSION['usuario'])){ ?>
    </ul>
    <div class="btn waves-effect waves-light" style="margin-left: 28%">
        Hay que estar conectado o registrado para responder aquí.
        <?php } ?>
    </div>
</div>
