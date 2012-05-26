<form class="form-validate" name="userform" method="post" action="index.php">
	
	<div class="clear">
		<label for="tituloEspanol">Título en español: </label>
		<input type="text" id="tituloEspanol" name="tituloEspanol"/>
	</div>
	
	<div class="clear">
		<label for="titulo">Título original: </label>
		<input type="text" id="titulo" name="titulo"/>
	</div>
	
	<div class="clear">
		<label for="anno">Año: </label>
		<input type="text" id="anno" name="anno"/>
	</div>
	
	<div class="clear">
		<label for="nombreDirector">Nombre del director: </label>
		<input type="text" id="nombreDirector" name="nombreDirector"/>
	</div>
	
	<div class="clear">
		<label for="categoria">Categoría: </label>
		<select name="idCategoria" id="idCategoria">
			<option value="0" selected> - </option>
		<?php
			foreach($this->categorias as $categoria){
				$idCategoria = $categoria["id"];
				echo "<option value='$idCategoria'>".$categoria["categoria"]."</option>";
			}
		?>
		</select>
	</div>
	
	<div class="clear">
		<label for="nombreActor1">Nombre actor: </label>
		<input type="text" id="nombreActor1" name="nombreActor1"/>
	</div>

	<div class="clear">
		<label for="nombreActor2">Nombre actor: </label>
		<input type="text" id="nombreActor2" name="nombreActor2"/>
	</div>	
	
	<div class="clear">
		<label for="nombreActor3">Nombre actor: </label>
		<input type="text" id="nombreActor3" name="nombreActor3"/>
	</div>
	
	<div class="clear left">
		<button type="submit" value="Buscar">Buscar</button>
	</div>
	
	
	<input type="hidden" name="option" value="com_peliculas" />
    <input type="hidden" name="task" value="busquedaAvanzada" />	
	
</form>

<form name="userform" method="post" action="index.php">
	<div class="clear">
	
		<?php 
		if (isset($this->peliculas)){
		?>
		
		<table cols="2">
			<thead>
				<tr>
					<th class="title"><?php echo JHTML::_('grid.sort', 'Título (título en español)', 'titulo', $this->filter_order_Dir, $this->filter_order); ?></th>
					<th class="title"><?php echo JHTML::_('grid.sort', 'Año (título en español)', 'anno', $this->filter_order_Dir, $this->filter_order); ?></th>
				</tr>
			</thead>
			
			
			<?php
			if(count($this->peliculas) > 0){
				foreach($this->peliculas as $pelicula){
					$idPelicula = $pelicula["id"];
				?>
					<tr>
						<td><?php echo "<a href='index.php?option=com_peliculas&task=verDetalles&id=$idPelicula'>".$pelicula["titulo"]." (".$pelicula["tituloEspanol"].")"."</a>"; ?></td>
						<td><?php echo $pelicula["anno"]; ?></td>
					</tr>
				<?php
				}
			}else{
				echo "No se han encontrado películas";	
			}?>
			<tfoot>
	            <tr>
	                <td colspan="6">
	                    <?php echo $this->pagination->getListFooter(); ?>
	                </td>
	            </tr>
	        </tfoot>
		</table>
		<?php	
		} ?>	
	</div>
</form>