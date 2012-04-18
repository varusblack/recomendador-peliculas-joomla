<?php
defined('_JEXEC') or die('Restricted access');
?>
<form action="index.php" method="post" name="adminForm">
    <table class="admintable">
        <tr>
            <td width="100" align="right" class="key">
                <label for="nombreCategoria">Nombre de la categoría:</label>
            </td>
            <td>
                <input type="text" name="nombreCategoria" id="nombreCategoria" maxlength="100" value="<?php echo $this->categoria['categoria']; ?>" />
            </td>
        </tr>


    </table>
    <input type="hidden" name="option" value="com_peliculas" />
    <input type="hidden" name="controller" value="Categorias" />
    <input type="hidden" name="task" value="save" />
    <input type="hidden" name="id" value="<?php echo $this->categoria["id"]; ?>" />
    
</form>