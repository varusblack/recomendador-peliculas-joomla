<?php
defined('_JEXEC') or die('Restricted access');
?>
<form action="index.php" method="post" name="adminForm">
    <table class="admintable">
        <tr>
            <td width="100" align="right" class="key">
                <label for="idCategoria">Categoría:</label>
            </td>
            <td>
            	<select name="idCategoria" id="idCategoria">
            		<?php
            			foreach($this->categorias as $categoria){
            				$idCategoria = $categoria["id"];
            				echo "<option value='$idCategoria'>".$categoria["categoria"]."</option>";
            			}
            		?>
            	</select>
            </td>
        </tr>


    </table>
    <input type="hidden" name="option" value="com_peliculas" />
    <input type="hidden" name="controller" value="films" />
    <input type="hidden" name="id" value="<?php echo $this->film["id"]; ?>" />
    <input type="hidden" name="task" value="grabarCategoria" />
</form>