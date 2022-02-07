<h1> Bienvenido de nuevo <?php echo  $_SESSION['usuario'] ?></h1>
<img src="<?php echo $_SESSION['public']."img/".$_SESSION["foto"] ?>" alt="<?php echo $_SESSION["foto"] ?>" style="width: 20%">
<h3>Tus actuales permisos son:</h3>

<h5>
<?php
    if($_SESSION["trabajadores"] == 1) echo "-Poder editar Trabajadores.<br>"
?>
<?php
    if($_SESSION["componentes"] == 1) echo "-Poder editar Componentes.<br>"
?>
<?php
    if($_SESSION["reviews"] == 1) echo "-Poder editar Reviews.<br>"
?>
<?php
    if($_SESSION["discusiones"] == 1) echo "-Poder editar Discusiones.<br>"
?>
<?php
    if($_SESSION["hilo"] == 1) echo "-Poder editar Hilos.";
?>
</h5>