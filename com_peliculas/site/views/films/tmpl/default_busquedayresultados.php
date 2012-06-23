<?php
defined('_JEXEC') or die('Restricted access');

$path = '/media/com_peliculas/';
$filename = 'ajaxVotacion.js';
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

                    <div>
                        <label for="tituloEspanol">Título en español: </label>
                        <input type="text" id="tituloEspanol" name="tituloEspanol" value="<?php echo @$this->campos["tituloEspanol"]; ?>"/>
                    </div>

                    <div>
                        <label for="titulo">Título original: </label>
                        <input type="text" id="titulo" name="titulo" value="<?php echo @$this->campos["titulo"]; ?>"/>
                    </div>

                    <div>
                        <label for="anno">Año: </label>
                        <input type="text" id="anno" name="anno" value="<?php echo @$this->campos["anno"]; ?>"/>
                    </div>

                    <div>
                        <label for="nombreDirector">Nombre del director: </label>
                        <input type="text" id="nombreDirector" name="nombreDirector" value="<?php echo @$this->campos["nombreDirector"]; ?>"/>
                    </div>

                    <div>
                        <label for="categoria">Categoría: </label>
                        <select name="idCategoria" id="idCategoria">
                            <option value="0" selected> - </option>
			    <?php
			    foreach ($this->categorias as $categoria) {
				$idCategoria = $categoria["id"];
				if (isset($this->campos["idCategoria"]) && $this->campos["idCategoria"] == $idCategoria) {
				    echo "<option value='$idCategoria' selected>" . $categoria["categoria"] . "</option>";
				} else {
				    echo "<option value='$idCategoria'>" . $categoria["categoria"] . "</option>";
				}
			    }
			    ?>
                        </select>
                    </div>

                    <div>
                        <label for="nombreActor1">Nombre actor: </label>
                        <input type="text" id="nombreActor1" name="nombreActor1" value="<?php echo @$this->campos["nombreActor1"]; ?>"/>
                    </div>

                    <div>
                        <label for="nombreActor2">Nombre actor: </label>
                        <input type="text" id="nombreActor2" name="nombreActor2" value="<?php echo @$this->campos["nombreActor2"]; ?>"/>
                    </div>	

                    <div>
                        <label for="nombreActor3">Nombre actor: </label>
                        <input type="text" id="nombreActor3" name="nombreActor3" value="<?php echo @$this->campos["nombreActor3"]; ?>"/>
                    </div>
                </div>
            </div>
        </div>


	<div class="centrado">
	    <button type="submit" value="Buscar">Buscar</button>
	    <button type="reset" value="Limpiar valores">Limpiar valores</button>
	</div>


	<input type="hidden" name="option" value="com_peliculas" />
	<input type="hidden" name="task" value="busquedaAvanzada" />	

</form>

<form name="userForm" method="post" action="index.php">

    <?php
    if (isset($this->texto))
	echo $this->texto;
    ?>

    <input type="hidden" name="option" value="com_peliculas" />
    <input type="hidden" name="task" value="busquedaAvanzada" />
</form>