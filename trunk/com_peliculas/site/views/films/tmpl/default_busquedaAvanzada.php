<form class="" name="userform" method="post" action="index.php">
	
	<label for="tituloEspanol">Título en español: </label>
	<input type="text" id="tituloEspanol" name="tituloEspanol"/>
	
	<label for="titulo">Título original: </label>
	<input type="text" id="titulo" name="titulo"/>
	
	<label for="anno">Año: </label>
	<input type="text" id="anno" name="anno"/>
	
	<label for="nombreDirector">Nombre del director: </label>
	<input type="text" id="nombreDirector" name="nombreDirector"/>
	
	<label for="categoria">Categoría: </label>
	<select name="idCategoria" id="idCategoria">
	<?php
		foreach($this->categorias as $categoria){
			$idCategoria = $categoria["id"];
			echo "<option value='$idCategoria'>".$categoria["categoria"]."</option>";
		}
	?>
	</select>
	
	<label for="nombreActor1">Nombre actor: </label>
	<input type="text" id="nombreActor1" name="nombreActor1"/>
	
	<label for="nombreActor2">Nombre actor: </label>
	<input type="text" id="nombreActor2" name="nombreActor2"/>
	
	<label for="nombreActor3">Nombre actor: </label>
	<input type="text" id="nombreActor3" name="nombreActor3"/>
	
</form>