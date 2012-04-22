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
        		<label for="videoRelease">Salida a la venta:</label>
        	</td>
        	<td>
        		<input type="text" width="100" name="videoRelease" id="videoRelease" maxlength="300" value="<?php echo $this->film["videoRelease"]; ?>"/>
        	</td>
        </tr>
        <tr>
        	<td width="100" align="right" class="key">
        		<label for="imdbUrl">Url IMDB:</label>
        	</td>
        	<td>
        		<input type="text" width="400" name="imdbUrl" id="imdbUrl" maxlength="300" value="<?php echo $this->film["IMDBurl"]; ?>"/>
        	</td>
        </tr>
        <tr>
        	<td width="100" align="right" class="key">
        		<label for="titulo2">Título 2:</label>
        	</td>
        	<td>
        		<input type="text" width="200" name="titulo2" id="titulo2" maxlength="300" value="<?php echo $this->film["titulo2"]; ?>"/>
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
        <tr>
        	<td width="100" align="right" class="key">
        		<label for="urlCartel">Url cartel:</label>
        	</td>
        	<td>
        		<input type="text" width="400" name="urlCartel" id="urlCartel" maxlength="300" value="<?php echo $this->film["urlCartel"]; ?>"/>
        	</td>
        </tr>
        <tr>
        	<td width="100" align="right" class="key">
        		<label for="idDirector">Director:</label>
        	</td>
        	<td>
        		<select name="idDirector" id="idDirector">
        			<?php foreach ($this->famosos as $famoso){
        				$idFamoso = $famoso["id"];
						if($this->film["idDirector"] == $famoso["id"]){
							echo "<option value='$idFamoso' selected>".$famoso["nombre"]. "</option>";
						}else{
							echo "<option value='$idFamoso'>".$famoso["nombre"]. "</option>";
						}
        			} ?>
        		</select>
        	</td>
        </tr>
        <?php
        	$actoresNumerados = array();
        	$contador = 1;
        	foreach ($this->actores as $actor){
        		$actoresNumerados[$contador] = $actor;
				$contador = $contador + 1;
        	}
        ?>
        <tr>
        	<td width="100" align="right" class="key">
        		<label for="idActor1">Actor 1:</label>
        	</td>
        	<td>
        		<select name="idActor1" id="idActor1">
        			<?php
        			if(isset($actoresNumerados[1])){
        				foreach ($this->famosos as $famoso){
        					$actorNumerado = $actoresNumerados[1];
							if ($actorNumerado["id"] == $famoso["id"]){
        						$idFamoso = $famoso["id"];
        						echo "<option value='$idFamoso' selected>".$famoso["nombre"]. "</option>";
        					}else{
        						echo "<option value='$idFamoso'>".$famoso["nombre"]. "</option>";
        					}
						}
        			}else{
        				foreach ($this->famosos as $famoso){
        					$idFamoso = $famoso["id"];
        					echo "<option value='$idFamoso'>".$famoso["nombre"]. "</option>";
        				}
        			}
        			?>
        		</select>
        	</td>
        </tr>
        <tr>
        	<td width="100" align="right" class="key">
        		<label for="idActor2">Actor 2:</label>
        	</td>
        	<td>
        		<select name="idActor2" id="idActor2">
        			<?php
        			if(isset($actoresNumerados[2])){
        				foreach ($this->famosos as $famoso){
        					$actorNumerado = $actoresNumerados[2];
							if ($actorNumerado["id"] == $famoso["id"]){
        						$idFamoso = $famoso["id"];
        						echo "<option value='$idFamoso' selected>".$famoso["nombre"]. "</option>";
        					}else{
        						echo "<option value='$idFamoso'>".$famoso["nombre"]. "</option>";
        					}
						}
        			}else{
        				foreach ($this->famosos as $famoso){
        					$idFamoso = $famoso["id"];
        					echo "<option value='$idFamoso'>".$famoso["nombre"]. "</option>";
        				}
        			}
        			?>
        		</select>
        	</td>
        </tr>
        <tr>
        	<td width="100" align="right" class="key">
        		<label for="idActor3">Actor 3:</label>
        	</td>
        	<td>
        		<select name="idActor3" id="idActor3">
        			<?php
        			if(isset($actoresNumerados[3])){
        				foreach ($this->famosos as $famoso){
        					$actorNumerado = $actoresNumerados[3];
							if ($actorNumerado["id"] == $famoso["id"]){
        						$idFamoso = $famoso["id"];
        						echo "<option value='$idFamoso' selected>".$famoso["nombre"]. "</option>";
        					}else{
        						echo "<option value='$idFamoso'>".$famoso["nombre"]. "</option>";
        					}
						}
        			}else{
        				foreach ($this->famosos as $famoso){
        					$idFamoso = $famoso["id"];
        					echo "<option value='$idFamoso'>".$famoso["nombre"]. "</option>";
        				}
        			}
        			?>
        		</select>
        	</td>
        </tr>
        <tr>
        	<td width="100" align="right" class="key">
        		<label for="idActor4">Actor 4:</label>
        	</td>
        	<td>
        		<select name="idActor4" id="idActor4">
        			<?php
        			if(isset($actoresNumerados[4])){
        				foreach ($this->famosos as $famoso){
        					$actorNumerado = $actoresNumerados[4];
							if ($actorNumerado["id"] == $famoso["id"]){
        						$idFamoso = $famoso["id"];
        						echo "<option value='$idFamoso' selected>".$famoso["nombre"]. "</option>";
        					}else{
        						echo "<option value='$idFamoso'>".$famoso["nombre"]. "</option>";
        					}
						}
        			}else{
        				foreach ($this->famosos as $famoso){
        					$idFamoso = $famoso["id"];
        					echo "<option value='$idFamoso'>".$famoso["nombre"]. "</option>";
        				}
        			}
        			?>
        		</select>
        	</td>
        </tr>
        <tr>
        	<td width="100" align="right" class="key">
        		<label for="idActor5">Actor 5:</label>
        	</td>
        	<td>
        		<select name="idActor5" id="idActor5">
        			<?php
        			if(isset($actoresNumerados[5])){
        				foreach ($this->famosos as $famoso){
        					$actorNumerado = $actoresNumerados[5];
							if ($actorNumerado["id"] == $famoso["id"]){
        						$idFamoso = $famoso["id"];
        						echo "<option value='$idFamoso' selected>".$famoso["nombre"]. "</option>";
        					}else{
        						echo "<option value='$idFamoso'>".$famoso["nombre"]. "</option>";
        					}
						}
        			}else{
        				foreach ($this->famosos as $famoso){
        					$idFamoso = $famoso["id"];
        					echo "<option value='$idFamoso'>".$famoso["nombre"]. "</option>";
        				}
        			}
        			?>
        		</select>
        	</td>
        </tr>
        <?php
        	$categoriasNumeradas = array();
        	$contador = 1;
        	foreach ($this->categoriasPelicula as $categoria){
        		$categoriasNumeradas[$contador] = $categoria;
				$contador = $contador + 1;
        	}
        ?>
        <tr>
        	<td width="100" align="right" class="key">
        		<label for="idCategoria1">Categoría 1:</label>
        	</td>
        	<td>
        		<select name="idCategoria1" id="idCategoria1">
        			<?php
        			if(isset($categoriasNumeradas[1])){
        				foreach ($this->categorias as $categoria){
        					$categoriaNumerada = $categoriasNumeradas[1];
							if ($categoriaNumerada["id"] == $categoria["id"]){
        						$idCategoria = $categoria["id"];
        						echo "<option value='$idCategoria' selected>".$categoria["categoria"]. "</option>";
        					}else{
        						echo "<option value='$idCategoria'>".$categoria["categoria"]. "</option>";
        					}
						}
        			}else{
        				foreach ($this->categorias as $categoria){
							$idCategoria = $categoria["id"];
        					echo "<option value='$idCategoria'>".$categoria["categoria"]. "</option>";
        				}
        			}
        			?>
        		</select>
        	</td>
        </tr>
        <tr>
        	<td width="100" align="right" class="key">
        		<label for="idCategoria2">Categoría 2:</label>
        	</td>
        	<td>
        		<select name="idCategoria2" id="idCategoria2">
        			<?php
        			if(isset($categoriasNumeradas[2])){
        				foreach ($this->categorias as $categoria){
        					$categoriaNumerada = $categoriasNumeradas[2];
							if ($categoriaNumerada["id"] == $categoria["id"]){
        						$idCategoria = $categoria["id"];
        						echo "<option value='$idCategoria' selected>".$categoria["categoria"]. "</option>";
        					}else{
        						echo "<option value='$idCategoria'>".$categoria["categoria"]. "</option>";
        					}
						}
        			}else{
        				foreach ($this->categorias as $categoria){
							$idCategoria = $categoria["id"];
        					echo "<option value='$idCategoria'>".$categoria["categoria"]. "</option>";
        				}
        			}
        			?>
        		</select>
        	</td>
        </tr>
        <tr>
        	<td width="100" align="right" class="key">
        		<label for="idCategoria3">Categoría 3:</label>
        	</td>
        	<td>
        		<select name="idCategoria3" id="idCategoria3">
        			<?php
        			if(isset($categoriasNumeradas[3])){
        				foreach ($this->categorias as $categoria){
        					$categoriaNumerada = $categoriasNumeradas[3];
							if ($categoriaNumerada["id"] == $categoria["id"]){
        						$idCategoria = $categoria["id"];
        						echo "<option value='$idCategoria' selected>".$categoria["categoria"]. "</option>";
        					}else{
        						echo "<option value='$idCategoria'>".$categoria["categoria"]. "</option>";
        					}
						}
        			}else{
        				foreach ($this->categorias as $categoria){
							$idCategoria = $categoria["id"];
        					echo "<option value='$idCategoria'>".$categoria["categoria"]. "</option>";
        				}
        			}
        			?>
        		</select>
        	</td>
        </tr>

    </table>
    <input type="hidden" name="option" value="com_peliculas" />
    <input type="hidden" name="controller" value="films" />
    <input type="hidden" name="id" value="<?php echo $this->film["id"]; ?>" />
    <input type="hidden" name="task" value="save" />
</form>