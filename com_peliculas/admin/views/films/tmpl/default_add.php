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
                <input type="text" width="200" name="titulo" id="titulo" maxlength="300" />
            </td>
        </tr>
        <tr>
        	<td width="100" align="right" class="key">
        		<label for="anno">Año:</label>
        	</td>
        	<td>
        		<input type="text" width="100" name="anno" id="anno" maxlength="300" />
        	</td>
        </tr>
        <tr>
        	<td width="100" align="right" class="key">
        		<label for="videoRelease">Salida a la venta:</label>
        	</td>
        	<td>
        		<input type="text" width="100" name="videoRelease" id="videoRelease" maxlength="300" />
        	</td>
        </tr>
        <tr>
        	<td width="100" align="right" class="key">
        		<label for="imdbUrl">Url IMDB:</label>
        	</td>
        	<td>
        		<input type="text" width="400" name="imdbUrl" id="imdbUrl" maxlength="300" />
        	</td>
        </tr>
        <tr>
        	<td width="100" align="right" class="key">
        		<label for="titulo2">Título 2:</label>
        	</td>
        	<td>
        		<input type="text" width="200" name="titulo2" id="titulo2" maxlength="300" />
        	</td>
        </tr>
        <tr>
        	<td width="100" align="right" class="key">
        		<label for="tituloEsp">Título en español:</label>
        	</td>
        	<td>
        		<input type="text" width="200" name="tituloEsp" id="tituloEsp" maxlength="300" />
        	</td>
        </tr>
        <tr>
        	<td width="100" align="right" class="key">
        		<label for="urlCartel">Url cartel:</label>
        	</td>
        	<td>
        		<input type="text" width="400" name="urlCartel" id="urlCartel" maxlength="300" />
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
        				echo "<option value='$idFamoso'>".$famoso["nombre"]. "</option>";
        			} ?>
        		</select>
        	</td>
        </tr>
        <tr>
        	<td width="100" align="right" class="key">
        		<label for="idActor1">Actor 1:</label>
        	</td>
        	<td>
        		<select name="idActor1" id="idActor1">
        			<?php foreach ($this->famosos as $famoso){
        				$idFamoso = $famoso["id"];
        				echo "<option value='$idFamoso'>".$famoso["nombre"]. "</option>";
        			} ?>
        		</select>
        	</td>
        </tr>
        <tr>
        	<td width="100" align="right" class="key">
        		<label for="idActor2">Actor 2:</label>
        	</td>
        	<td>
        		<select name="idActor2" id="idActor2">
        			<?php foreach ($this->famosos as $famoso){
        				$idFamoso = $famoso["id"];
        				echo "<option value='$idFamoso'>".$famoso["nombre"]. "</option>";
        			} ?>
        		</select>
        	</td>
        </tr>
        <tr>
        	<td width="100" align="right" class="key">
        		<label for="idActor3">Actor 3:</label>
        	</td>
        	<td>
        		<select name="idActor3" id="idActor3">
        			<?php foreach ($this->famosos as $famoso){
        				$idFamoso = $famoso["id"];
        				echo "<option value='$idFamoso'>".$famoso["nombre"]. "</option>";
        			} ?>
        		</select>
        	</td>
        </tr>
        <tr>
        	<td width="100" align="right" class="key">
        		<label for="idActor4">Actor 4:</label>
        	</td>
        	<td>
        		<select name="idActor4" id="idActor4">
        			<?php foreach ($this->famosos as $famoso){
        				$idFamoso = $famoso["id"];
        				echo "<option value='$idFamoso'>".$famoso["nombre"]. "</option>";
        			} ?>
        		</select>
        	</td>
        </tr>
        <tr>
        	<td width="100" align="right" class="key">
        		<label for="idActor5">Actor 5:</label>
        	</td>
        	<td>
        		<select name="idActor5" id="idActor5">
        			<?php foreach ($this->famosos as $famoso){
        				$idFamoso = $famoso["id"];
        				echo "<option value='$idFamoso'>".$famoso["nombre"]. "</option>";
        			} ?>
        		</select>
        	</td>
        </tr>
        <tr>
        	<td width="100" align="right" class="key">
        		<label for="idCategoria1">Categoría 1:</label>
        	</td>
        	<td>
        		<select name="idCategoria1" id="idCategoria1">
        			<?php foreach ($this->categorias as $categoria){
        				$idCategoria = $categoria["id"];
        				echo "<option value='$idCategoria'>".$categoria["categoria"]. "</option>";
        			} ?>
        		</select>
        	</td>
        </tr>
        <tr>
        	<td width="100" align="right" class="key">
        		<label for="idCategoria2">Categoría 2:</label>
        	</td>
        	<td>
        		<select name="idCategoria2" id="idCategoria2">
        			<?php foreach ($this->categorias as $categoria){
        				$idCategoria = $categoria["id"];
        				echo "<option value='$idCategoria'>".$categoria["categoria"]. "</option>";
        			} ?>
        		</select>
        	</td>
        </tr>
        <tr>
        	<td width="100" align="right" class="key">
        		<label for="idCategoria3">Categoría 3:</label>
        	</td>
        	<td>
        		<select name="idCategoria3" id="idCategoria3">
        			<?php foreach ($this->categorias as $categoria){
        				$idCategoria = $categoria["id"];
        				echo "<option value='$idCategoria'>".$categoria["categoria"]. "</option>";
        			} ?>
        		</select>
        	</td>
        </tr>


    </table>
    <input type="hidden" name="option" value="com_peliculas" />
    <input type="hidden" name="controller" value="films" />
    <input type="hidden" name="id" value="" />
    <input type="hidden" name="task" value="save" />
</form>