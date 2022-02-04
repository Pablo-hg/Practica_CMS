<h1> Bienvenido de nuevo <?php echo  $_SESSION['usuario'] ?></h1>

<h3>Tus actuales permisos son:</h3>

<?php
    if($_SESSION["trabajadores"] == 1) echo "-Poder editar Trabajadores."
?><br>
<?php
    if($_SESSION["componentes"] == 1) echo "-Poder editar Componentes."
?><br>
<?php
    if($_SESSION["reviews"] == 1) echo "-Poder editar Reviews."
?><br>
<?php
    if($_SESSION["discusiones"] == 1) echo "-Poder editar Discusiones."
?><br>
<?php
    if($_SESSION["hilo"] == 1) echo "-Poder editar Hilos."
?><br>
