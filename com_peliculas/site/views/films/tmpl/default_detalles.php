<?php
defined('_JEXEC') or die('Restricted access');
?>

<form class="user" name="userform" method="post" action="index.php" >
	
	<div class="leading">
		<h4 class="contentheading"><?php echo $this->pelicula["titulo"]." (".$this->pelicula["tituloEspanol"].")" ?></h4>
		
		<div class="clear">
			<span class="modifydate">Año: </span>
			<span><?php echo  $this->pelicula["anno"]?></span>
		</div>
		
		<div class="clear">
		<?php 
        if(sizeof($this->categorias) > 0) {
        	$contador = 1;
			foreach ($this->categorias as $categoria){?>
				<span class="modifydate"><?php echo "Categoría $contador: "; ?></span>
				<span><?php echo $categoria["categoria"]; ?></span>
				<br/>
		<?php 
				$contador = $contador + 1;
			}
        }
		?>
		</div>
		
		<div class="clear">
			<span class="modifydate">Director: </span>
			<span><?php echo  $this->pelicula["director"]?></span>
		</div>
		
		<div class="clear">
		<?php
		if(sizeof($this->actores) > 0){
			$contador = 1;
			foreach ($this->actores as $actor) {?>
				<span class="modifydate"><?php echo "Actor $contador: "; ?></span>
				<span><?php echo $actor["nombre"]; ?></span>
				<br/>
		<?php	
				$contador = $contador + 1;
			}
		}
		?>
		</div>
	
		<?php  
		if(isset($this->otrosdatos)){
		?>	
		<div class="clear">
			<span class="modifydate">Puntuación: </span>
			<select name="puntuacion" id="puntuacion">
			<?php  
			for($i=1;$i<6;$i++){ 
				if($i.".00" == $this->otrosdatos["puntuacion"]){ ?>
					<option selected value="<?php echo $i.".00"; ?>"><?php echo $i.".00"; ?></option>
			<?php
				}else{ ?>
					<option value="<?php echo $i.".00"; ?>"><?php echo $i.".00"; ?></option>
			<?php
				}
			} ?>
			</select>
		</div>
		
		<div class="clear left">
			<button type="submit" class="button validate" onclick="submitbutton(this.form);return false">Guardar</button>
		</div>
		<?php 
		}
		?>
	</div>
	
    <input type="hidden" name="id" value="<?php echo $this->pelicula["id"]; ?>" />
	<input type="hidden" name="option" value="com_peliculas" />
    <input type="hidden" name="task" value="cambiarVoto" />	
</form>

<button type="button" onclick="location.href='javascript:history.back(1)'">Atrás</button>