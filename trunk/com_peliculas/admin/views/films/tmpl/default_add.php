<?php
defined('_JEXEC') or die('Restricted access');
$editor = &JFactory::getEditor();
?>
<form action="index.php" method="post" name="adminForm">
    <table class="admintable">
        <tr>
            <td width="100" align="right" class="key">
                <label for="titulo">Título:</label>
            </td>
            <td>
                <input type="text" size="100%" name="titulo" id="titulo" maxlength="255" />
            </td>
        </tr>
        <tr>
	    <td width="100" align="right" class="key">
		<label for="anno">Año:</label>
	    </td>
	    <td>
		<input type="text" size="100%" name="anno" id="anno" maxlength="255" />
	    </td>
        </tr>
        <tr>
	    <td width="100" align="right" class="key">
		<label for="tituloEsp">Título en español:</label>
	    </td>
	    <td>
		<input type="text" size="100%" name="tituloEsp" id="tituloEsp" maxlength="255" />
	    </td>
        </tr>
	<tr>
	    <td width="100" align="right" class="key">
		<label for="tituloEsp">Sinopsis:</label>
	    </td>
	    <td>
		<?php echo $editor->display("sinopsis", "", '70%', '250', '40', '5'); ?>
	    </td>
        </tr>
	<tr>
	    <td width="100" align="right" class="key">
		<label for="tituloEsp">Archivo con el cartel (.jpg):</label>
	    </td>
	    <td>
		<input type="file" name="cartel" id="cartel" />
	    </td>
        </tr>


    </table>
    <input type="hidden" name="option" value="com_peliculas" />
    <input type="hidden" name="controller" value="films" />
    <input type="hidden" name="id" value="" />
    <input type="hidden" name="task" value="save" />
</form>