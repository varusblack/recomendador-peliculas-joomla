<?php
	$filename = 'table-ordering.js';
	$path = '.';
	JHTML::script($filename, $path);
	JHTML::stylesheet('peliculas.css', '/media/com_peliculas/');
?>
<form class="form-validate" name="userform" method="post" action="index.php">
	<div class="Post">
		<div class="Post-tl"></div>
		<div class="Post-tr"></div>
		<div class="Post-bl"></div>
		<div class="Post-br"></div>
		<div class="Post-tc"></div>
		<div class="Post-bc"></div>
		<div class="Post-cl"></div>
		<div class="Post-cr"></div>
		<div class="Post-cc"></div>
		<div class="Post-body">
			<div class="Post-inner">
				<div class="PostContent">
					<div class="cleared">
						<label for="tituloEspanol">Título en español: </label>
							<?php 
							$camposPrevios = $this->camposPrevios;
							if(isset($camposPrevios["tituloEspanol"])){ ?>
								<input type="text" id="tituloEspanol" name="tituloEspanol" value="<?php echo $camposPrevios["tituloEspanol"]; ?>"/>
							<?php }else{ ?>
								<input type="text" id="tituloEspanol" name="tituloEspanol"/>
							<?php } ?>
					</div>
					
					<div class="cleared">
						<label for="titulo">Título original: </label>
						<?php 
						if(isset($camposPrevios["titulo"])){ ?>
							<input type="text" id="titulo" name="titulo" value="<?php echo $camposPrevios["titulo"]; ?>"/>
						<?php }else{ ?>
							<input type="text" id="titulo" name="titulo"/>
						<?php } ?>
					</div>
					
					<div class="cleared">
						<label for="anno">Año: </label>
						<?php 
						if(isset($camposPrevios["anno"])){ ?>
							<input type="text" id="anno" name="anno" value="<?php echo $camposPrevios["anno"]; ?>"/>
						<?php }else{ ?>
							<input type="text" id="anno" name="anno"/>
						<?php } ?>
					</div>
					
					<div class="cleared">
						<label for="nombreDirector">Nombre del director: </label>
						<?php 
						if(isset($camposPrevios["nombreDirector"])){ ?>
							<input type="text" id="nombreDirector" name="nombreDirector" value="<?php echo $camposPrevios["nombreDirector"]; ?>"/>
						<?php }else{ ?>
							<input type="text" id="nombreDirector" name="nombreDirector"/>
						<?php } ?>
					</div>
					
					<div class="cleared">
						<label for="categoria">Categoría: </label>
						<select name="idCategoria" id="idCategoria">
							<option value="0" selected> - </option>
						<?php
							foreach($this->categorias as $categoria){
								$idCategoria = $categoria["id"];
								if(isset($camposPrevios["idCategoria"]) && $camposPrevios["idCategoria"]==$idCategoria) {
									echo "<option value='$idCategoria' selected>".$categoria["categoria"]."</option>";
								}else{
									echo "<option value='$idCategoria'>".$categoria["categoria"]."</option>";
								}
							}
						?>
						</select>
					</div>
					
					<div class="cleared">
						<label for="nombreActor1">Nombre actor: </label>
						<?php 
						if(isset($camposPrevios["nombreActor1"])){ ?>
							<input type="text" id="nombreActor1" name="nombreActor1" value="<?php echo $camposPrevios["nombreActor1"]; ?>"/>
						<?php }else{ ?>
							<input type="text" id="nombreActor1" name="nombreActor1"/>
						<?php } ?>
					</div>
				
					<div class="cleared">
						<label for="nombreActor2">Nombre actor: </label>
						<?php 
						if(isset($camposPrevios["nombreActor2"])){ ?>
							<input type="text" id="nombreActor2" name="nombreActor2" value="<?php echo $camposPrevios["nombreActor2"]; ?>"/>
						<?php }else{ ?>
							<input type="text" id="nombreActor2" name="nombreActor2"/>
						<?php } ?>
					</div>	
					
					<div class="cleared">
						<label for="nombreActor3">Nombre actor: </label>
						<?php 
						if(isset($camposPrevios["nombreActor3"])){ ?>
							<input type="text" id="nombreActor3" name="nombreActor3" value="<?php echo $camposPrevios["nombreActor3"]; ?>"/>
						<?php }else{ ?>
							<input type="text" id="nombreActor3" name="nombreActor3"/>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	
	
	<div class="cleared">
		<button type="submit" value="Buscar">Buscar</button>
	</div>
	
	
	<input type="hidden" name="option" value="com_peliculas" />
    <input type="hidden" name="task" value="busquedaAvanzada" />	
    <input type="hidden" name="camposPrevios" value="<?php echo base64_encode(serialize($this->camposPrevios)); ?>" />
	
</form>

<form name="userForm" method="post" action="index.php">
	
	<div class="Post">
		<div class="Post-tl"></div>
		<div class="Post-tr"></div>
		<div class="Post-bl"></div>
		<div class="Post-br"></div>
		<div class="Post-tc"></div>
		<div class="Post-bc"></div>
		<div class="Post-cl"></div>
		<div class="Post-cr"></div>
		<div class="Post-cc"></div>
		<div class="Post-body">
			<div class="Post-inner">
				<div class="PostContent">
					<div class="clear">
						<?php 
						if (isset($this->peliculas)){
						?>
						<table class="table" cols="2">
							<thead>
								<tr>
									<th class="title"><?php echo JHTML::_('grid.sort', 'Título (título en español)', 'titulo', $this->filter_order_Dir, $this->filter_order); ?></th>
									<th class="title"><?php echo JHTML::_('grid.sort', 'Año', 'anno', $this->filter_order_Dir, $this->filter_order); ?></th>
								</tr>
							</thead>
							
							<?php
							$paginacion = TRUE;
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
								$paginacion = FALSE;
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
				</div>
			</div>
		</div>
	</div>
	
	
	
	
	
	<input type="hidden" name="option" value="com_peliculas" />
    <input type="hidden" name="task" value="busquedaAvanzada" />
    <input type="hidden" name="paginacion" value="<?php echo base64_encode(serialize($paginacion)); ?>" />
    <input type="hidden" name="filter_order" value="<?php echo $this->filter_order; ?>" />
    <input type="hidden" name="filter_order_Dir" value="" />
    <input type="hidden" name="filter_state" value="<?php echo $this->filter_state; ?>" />
    <input type="hidden" name="camposPrevios" value="<?php echo base64_encode(serialize($this->camposPrevios)); ?>" />
</form>