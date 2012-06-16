<?php
defined('_JEXEC') or die('Restricted access');
?>
<form action="index.php" method="post" name="adminForm">
    <table class="admintable">
		<tr>
            <td width="100" align="right" class="key">
                <label for="titulo">Título:</label>
            </td>
            <td>
                <input type="text" width="200" name="titulo" id="titulo" maxlength="300" value="<?php echo $this->film["titulo"]; ?>"/>
            </td>
        </tr>
        <tr>
        	<td width="100" align="right" class="key">
        		<label for="anno">Año:</label>
        	</td>
        	<td>
        		<input type="text" width="100" name="anno" id="anno" maxlength="300" value="<?php echo $this->film["anno"]; ?>"/>
        	</td>
        </tr>
        <tr>
        	<td width="100" align="right" class="key">
        		<label for="tituloEsp">Título en español:</label>
        	</td>
        	<td>
        		<input type="text" width="200" name="tituloEsp" id="tituloEsp" maxlength="300" value="<?php echo $this->film["tituloEspanol"]; ?>"/>
        	</td>
        </tr>
        <?php 
        if(sizeof($this->categorias) > 0) {
        	$contador = 1;
			foreach ($this->categorias as $categoria){?>
				<tr>
		        	<td width="100" align="right" class="key"><?php echo "Categoría $contador:"; ?></td>
		        	<td><?php echo $categoria["categoria"]; ?></td>
		        	<td><a href="<?php echo "index.php?option=com_peliculas&controller=films&task=borrarCategoria&cid[]=".$this->film["id"]."&idObj=".$categoria["id"]; ?>">
						<img src="/proyecto/media/com_peliculas/iconos/borrar.png" alt="borrar"/></a></td>
		        </tr>
			<?php 
				$contador = $contador + 1;
			}
        }
        
        if(sizeof($this->director) == 2){
		?>
		<tr>
        	<td width="100" align="right" class="key">Director:</td>
        	<td><?php echo $this->director["nombre"]; ?></td>
        	<td><a href="<?php echo "index.php?option=com_peliculas&controller=films&task=borrarDirector&cid[]=".$this->film["id"]; ?>">
				<img src="/proyecto/media/com_peliculas/iconos/borrar.png" alt="borrar"/></a></td>
        </tr>
		<?php
        }
		
		if(sizeof($this->actores) > 0){
			$contador = 1;
			foreach ($this->actores as $actor) {
				?>
				<tr>
		        	<td width="100" align="right" class="key"><?php echo "Actor $contador:"; ?></td>
		        	<td><?php echo $actor["nombre"]; ?></td>
		        	<td><a href="<?php echo "index.php?option=com_peliculas&controller=films&task=borrarActor&cid[]=".$this->film["id"]."&idObj=".$actor["id"]; ?>">
						<img src="/proyecto/media/com_peliculas/iconos/borrar.png" alt="borrar"/></a></td>
		        </tr>
				<?php
				$contador = $contador + 1;
			}
		}
		?>

    </table>
    <input type="hidden" name="option" value="com_peliculas" />
    <input type="hidden" name="controller" value="films" />
    <input type="hidden" name="id" value="<?php echo $this->film["id"]; ?>" />
    <input type="hidden" name="task" value="save" />
</form>