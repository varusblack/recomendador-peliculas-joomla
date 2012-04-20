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


    </table>
    <input type="hidden" name="option" value="com_peliculas" />
    <input type="hidden" name="controller" value="films" />
    <input type="hidden" name="id" value="" />
    <input type="hidden" name="task" value="save" />
</form>