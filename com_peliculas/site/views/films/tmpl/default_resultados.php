<?php
defined('_JEXEC') or die('Restricted access');
?>

<table cols="4">
	<tr>
		<th>Título (título en español)</th>
		<th>Categoría</th>
		<th>Año</th>
		<th>Puntuación</th>
	</tr>
	
	<?php
	if(count($this->peliculas) < 1){
		foreach($this->peliculas as $pelicula){
			$idPelicula = $pelicula["id"];
		?>
			<tr>
				<td><?php echo "<a href='index.php?option=com_peliculas&controller=Films&task=verDetalles&id=$idPelicula'>".$pelicula["titulo"]." (".$pelicula["tituloEspanol"].")"."</a>"; ?></td>
			<?php
			$categorias = $this->categoriasPeliculas[$idPelicula];
			$cadenaCategorias = '';
			foreach($categorias as $cat){
				$cadenaCategorias = $cadenaCategorias." ".$cat["categoria"];
			}
			?>
				<td><?php echo $cadenaCategorias; ?></td>
				<td><?php echo $pelicula["anno"]; ?></td>
				<td><?php echo $pelicula["puntuacion"]; ?></td>
			</tr>
		<?php
		}
	}else{
		echo "No se han encontrado películas";	
	}?>
	
</table>