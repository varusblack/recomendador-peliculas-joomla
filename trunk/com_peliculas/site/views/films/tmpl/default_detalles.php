<?php
defined('_JEXEC') or die('Restricted access');
?>

<form class="user" name="userform" method="post" action="index.php" >
	
	<div class="leading">
		<h4 class="contentheading"><?php echo $this->pelicula["titulo"]." (".$this->pelicula["tituloEspanol"].")" ?></h4>
		
		<span class="modifydate">Año: </span>
		<span><?php echo  $this->pelicula["anno"]?></span>
		
		<span class="modifydate">Salida a la venta: </span>
		
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
		
		<span class="modifydate">Puntuación: </span>
		<select name="puntuacion" id="puntuacion">
			<?php  
			for($i=1;$i<6;$i++){ 
				if($i.".00" == $this->pelicula["puntuacion"]){ ?>
					<option selected value="<?php echo $i.".00"; ?>"><?php echo $i.".00"; ?></option>
			<?php
				}else{ ?>
					<option value="<?php echo $i.".00"; ?>"><?php echo $i.".00"; ?></option>
			<?php
				}
			}
			
			// if($this->pelicula["puntuacion"] == "no"){ ?>
<!-- 				<option selected value="no">No la he visto</option> -->
			<?php	
			// }else{ ?>
<!-- 				<option value="no">No la he visto</option> -->
			<?php
			// }
			?> 
		</select>
		
		<button type="submit" class="button validate" onclick="submitbutton(this.form);return false">Guardar</button>
	</div>
	
    <input type="hidden" name="id" value="<?php echo $this->pelicula["id"]; ?>" />
	<input type="hidden" name="option" value="com_peliculas" />
    <input type="hidden" name="controller" value="films" />
    <input type="hidden" name="task" value="cambiarVoto" />	
</form>

<button type="button" onclick="location.href='index.php?option=com_peliculas&controller=films&task=vervotadas'">Atrás</button>