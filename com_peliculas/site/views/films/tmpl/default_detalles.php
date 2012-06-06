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
		<span class="modifydate">Categorías: </span>
			<span>
			<?php
			for ($i=0;$i<count($this->categorias);$i++){
				if($i != (count($this->categorias) - 1)){
					echo $this->categorias[$i]["categoria"].", ";
				}else{
					echo $this->categorias[$i]["categoria"];
				}
			}
			?>
			</span>
		</div>
		
		<div class="clear">
			<span class="modifydate">Director: </span>
			<span><?php echo  $this->director["nombre"]?></span>
		</div>
		
		<div class="clear">
			<span class="modifydate">Actores: </span>
			<span>
			<?php
			for ($i=0;$i<count($this->actores);$i++){
				if($i != (count($this->actores) - 1)){
					echo $this->actores[$i]["nombre"].", ";
				}else{
					echo $this->actores[$i]["nombre"];
				}
			}
			?>
			</span>
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
		<div style="float: right;">
			<?php echo "<img src='/proyecto/images/caratulas/2.jpg' border='0' width='10%' height='10%'>"; ?>
		</div>
	
    <input type="hidden" name="id" value="<?php echo $this->pelicula["id"]; ?>" />
	<input type="hidden" name="option" value="com_peliculas" />
    <input type="hidden" name="task" value="cambiarVoto" />	
</form>

<button type="button" onclick="location.href='javascript:history.back(1)'">Atrás</button>