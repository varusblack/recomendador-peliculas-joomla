<?php
defined('_JEXEC') or die('Restricted access');
?>

<table cols="3">
	<tr>
		<th>Título (título en español)</th>
		<th>Año</th>
		<th>Puntuación</th>
	</tr>
	
	<?php
	if(count($this->peliculas) > 0){
		foreach($this->peliculas as $pelicula){
			$idPelicula = $pelicula["id"];
		?>
			<tr>
				<td><?php echo "<a href='index.php?option=com_peliculas&task=verDetalles&id=$idPelicula'>".$pelicula["titulo"]." (".$pelicula["tituloEspanol"].")"."</a>"; ?></td>
				<td><?php echo $pelicula["anno"]; ?></td>
				<td><?php echo $pelicula["puntuacion"]; ?></td>
			</tr>
		<?php
		}
	}else{
		echo "No se han encontrado películas";	
	}?>
	
</table>