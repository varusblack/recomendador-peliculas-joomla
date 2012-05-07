<?php
defined('_JEXEC') or die('Restricted access');

?>
<form action="index.php" method="post" name="votaciones">
<?php
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
			
			<span class="modifydate">Salida a la venta: </span>
			<span><?php echo $pelicula["videoRelease"]; ?></span>
			
			<span class="modifydate">Director: </span>
			<span><?php echo $pelicula["director"]; ?></span>
			
			<span class="modifydate">Puntuación: </span>
			<select name="<?php echo "puntuacion".$contador; ?>" id="<?php echo "puntuacion".$contador; ?>">
				<option value="1">1.00</option>
				<option value="2">2.00</option>
				<option value="3">3.00</option>
				<option value="4">4.00</option>
				<option value="5">5.00</option>
				<option value="no">No la he visto</option>
			</select>
		</div>
		
	<?php
	$contador = $contador + 1;
	}
	?>

<!-- 	<div class="leading">
		<h2 class="contentheading">TITULO DE LA PELI (TITULO EN ESPAÑOL)</h2>
		<span class="modifydate">Categoría: </span>
		<span>CATEGORIA 1, CATEGORIA 2, CATEGORIA 3</span>
		
		<span class="modifydate">Año: </span>
		<span>AÑO</span>
		
		<span class="modifydate">Salida a la venta: </span>
		<span>SALIDA A LA VENTA</span>
		
		<span class="modifydate">Director: </span>
		<span>DIRECTOR</span>
		
		<span class="modifydate">Puntuación: </span>
		<select>
			<option>1.00</option>
			<option>2.00</option>
			<option>3.00</option>
			<option>4.00</option>
			<option>5.00</option>
			<option>No la he visto</option>
		</select>
	</div> -->
	
	<div align="center">
		<button type="submit"title="Votar"></button>
	</div>

	<input type="hidden" name="option" value="com_peliculas" />
    <input type="hidden" name="controller" value="films" />
    <input type="hidden" name="task" value="grabarVotos" />
    <input type="hidden" name="view" value="" />
	
</form>

