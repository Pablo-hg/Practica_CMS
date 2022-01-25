<h1> Discusiones </h1>
<div class="contenido">
    <ul class="collection">
        <?php foreach ($datos as $row){ ?>
        <li class="collection-item avatar">
            <img src="<?php echo $_SESSION['public']."img/".$row->imagen ?>" alt="perfil" class="circle">
            <span class="title">
                 <a href="<?php echo $_SESSION['home']."hilo/".$row->slug ?>">
                    <b style="color: #7badd6"> <?php echo $row->titulo ?> </b> </a>
            </span><br>
            <div class="datos">
                <?php echo $row->autor ?> . <?php echo date("d/m/Y", strtotime($row->fecha)) ?>
            </div>
            <div class="secondary-content" style="color: #7badd6">
                <div class="material-icons" >favorite_border</div>
                <span class="numlikes"><?php echo $row->likes ?></span>
            </div>

        <?php } ?>
    </ul>
</div>
