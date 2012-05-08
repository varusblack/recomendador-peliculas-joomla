<?php
defined('_JEXEC') or die('Restricted access');
?>

<form name="detalles" method="post" action="index.php" >
	
	<div class="leading">
		<h4 class="contentheading"><?php echo $this->pelicula["titulo"]." (".$this->pelicula["tituloEspanol"].")" ?></h4>
		
		
		<span class="modifydate">Año: </span>
		<span><?php echo  $this->pelicula["anno"]?></span>
		
		<span class="modifydate">Salida a la venta: </span>
		<span><?php echo  $this->pelicula["videoRelease"]?></span>
		
		<?php 
        if(sizeof($this->categorias) > 0) {
        	$contador = 1;
			foreach ($this->categorias as $categoria){?>
				<span class="modifydate"><?php echo "Categoría $contador: "; ?></span>
				<span><?php echo $categoria["categoria"]; ?></span>
		<?php 
				$contador = $contador + 1;
			}
        }
		?>
		
		<span class="modifydate">Director: </span>
		<span><?php echo  $this->pelicula["director"]?></span>
		
		<?php
		if(sizeof($this->actores) > 0){
			$contador = 1;
			foreach ($this->actores as $actor) {?>
				<span class="modifydate"><?php echo "Actor $contador: "; ?></span>
				<span><?php echo $actor["nombre"]; ?></span>
		<?php
				$contador = $contador + 1;
			}
		}
		?>
	</div>
	
</form>