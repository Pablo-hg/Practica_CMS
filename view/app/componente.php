

<div class="row">
    <img src="https://elchapuzasinformatico.com/wp-content/uploads/2022/01/B4nner-MSI-Intel-Z690.jpg" style="padding-top: 1rem">
    <h1>
        <span><?php echo $datos->titulo ?></span>
    </h1>
    <h3>
        Por <span style="color: rgba(31,110,163,.8);"> <?php echo $datos->autor ?></span>
        / <?php echo date("d/m/Y", strtotime($datos->fecha)) ?>
    </h3>
    <article class="col s12">
        <div class="card-image">
            <a href="<?php echo $_SESSION['home']."componente/".$datos->slug ?>">
                <img src="<?php echo $_SESSION['public']."img/".$datos->imagen ?>" alt="<?php echo $datos->titulo ?>">
            </a>
        </div>
        <div class="card-stacked">
            <div class="card-content">
                <h2><?php echo $datos->titulo ?></h2>
                <p class="card-action"><?php echo $datos->entradilla ?></p>
            </div>
        </div>
    </article>
</div>
<aside>
    <form>
        <div class="input-field">
            <input id="search" type="search" required>
            <label class="label-icon" for="search"><i class="material-icons">search</i></label>
            <i class="material-icons">close</i>
        </div>
    </form>
    <img src="https://elchapuzasinformatico.com/wp-content/uploads/2022/01/B4nner-MSI-Alder-Lake.jpg%22">
</aside>
