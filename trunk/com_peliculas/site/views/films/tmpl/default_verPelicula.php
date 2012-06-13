<?php
defined('_JEXEC') or die('Restricted access');
?>
<div class="Post">
    <div class="Post-tl"></div>
    <div class="Post-tr"></div>
    <div class="Post-bl"></div>
    <div class="Post-br"></div>
    <div class="Post-tc"></div>
    <div class="Post-bc"></div>
    <div class="Post-cl"></div>
    <div class="Post-cr"></div>
    <div class="Post-cc"></div>
    <div class="Post-body">
	<div class="Post-inner">
	    <div class="PostContent">
		<div class="cartel">
		    <img src="index.php?option=com_peliculas&task=mostrarFoto&id=<?php echo $this->resultado["idPelicula"];?>&tam=200&format=raw">
		</div>
		<h3><?php echo $this->resultado["tituloEspanol"] . " (" . $this->resultado["titulo"] . ")" ?></h3>

		<div>
		    <span class="indicador">Año: </span>
		    <span><?php echo $this->resultado["anno"] ?></span>
		</div>

		<div>
		    <span class="indicador">Categorías: </span>
		    <span><?php echo $this->resultado["categorias"] ?></span>
		</div>

		<div>
		    <span class="indicador">Director: </span>
		    <span><?php echo $this->resultado["director"] ?></span>
		</div>

		<div>
		    <span class="indicador">Actores: </span>
		    <span><?php echo $this->resultado["actores"] ?></span>
		</div>

		<?php if (isset($this->resultado["puntuacion"])) { ?>
    		<span class="indicador">Puntuación: </span>
    		<select name="puntuacion" id="puntuacion" onchange="votar(<?php echo $this->resultado["idPelicula"]; ?>,this.value)">
			<?php if (strcmp($this->resultado["puntuacion"], "no") == 0) { ?>
			    <option selected="selected" value="no">No la he visto</option>
			<?php } else {
			    ?>
			    <option value="no">No la he visto</option>
			    <?php
			}

			for ($i = 1; $i < 6; $i++) {
			    if (strcmp($i . ".00", $this->resultado["puntuacion"]) == 0) {
				?>
	    		    <option selected="selected" value="<?php echo $i . ".00"; ?>"><?php echo $i . ".00"; ?></option>
			    <?php } else {
				?>
	    		    <option value="<?php echo $i . ".00"; ?>"><?php echo $i . ".00"; ?></option>
				<?php
			    }
			}
			?>
    		</select>
		<?php } ?>

	    </div>
	</div>
    </div>
</div>