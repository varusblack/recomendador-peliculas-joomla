<?php
defined('_JEXEC') or die('Restricted access');

?>
<form class="user" action="index.php" method="post" name="userform">
<?php
	if(count($this->peliculas) == 0){
		echo "No hay películas para votar.";
	}else{
		$contador = 1;
		foreach($this->peliculas as $pelicula){ ?>
			<div class="leading">
				<h2 class="contentheading"><?php echo $pelicula["tituloEspanol"]." (".$pelicula["titulo"].")"; ?></h2>
				<span class="modifydate">Categoría: </span>
				<?php
				$idPelicula = $pelicula["id"];
				$categorias = $this->categoriasPeliculas[$idPelicula];
				$cadenaCategorias = '';
				foreach($categorias as $cat){
					$cadenaCategorias = $cadenaCategorias." ,".$cat["categoria"];
				}
				?>
				<span><?php echo $cadenaCategorias; ?></span>
				
				<span class="modifydate">Año: </span>
				<span><?php echo $pelicula["anno"]; ?></span>
				
				<span class="modifydate">Director: </span>
				<span><?php echo $pelicula["director"]; ?></span>
				
				<span class="modifydate">Puntuación: </span>
				<select name="<?php echo "puntuacion".$idPelicula; ?>" id="<?php echo "puntuacion".$idPelicula; ?>">
					<option selected value="no">No la he visto</option>
					<option value="1.00">1</option>
					<option value="2.00">2</option>
					<option value="3.00">3</option>
					<option value="4.00">4</option>
					<option value="5.00">5</option>
				</select>
			</div>
			
	<?php
			$contador = $contador + 1;
		}
	?>
	<div align="center">
		<button type="submit"title="Votar">Votar</button>
	</div>
	<?php
	}
	?>
	
	

	<input type="hidden" name="option" value="com_peliculas" />
    <input type="hidden" name="task" value="votarMasivo" />
    <input type="hidden" name="identificadores" value="<?php echo base64_encode(serialize($this->identificadores)); ?>" />
	
</form>
