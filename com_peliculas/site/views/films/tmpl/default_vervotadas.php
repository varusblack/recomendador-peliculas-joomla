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
	foreach($this->peliculas as $pelicula){
	?>
		<tr>
			<td><?php echo $pelicula["titulo"]." (".$pelicula["tituloEspanol"].")"; ?></td>
		</tr>
		<tr>
			<td><?php echo $pelicula[""]; ?></td>
		</tr>
		<tr>
			<td><?php echo $pelicula["anno"]; ?></td>
		</tr>
		<tr>
			<td><?php echo $pelicula["puntuacion"]; ?></td>
		</tr>
	<?php
	}
	?>
	
	
	
	
</table>