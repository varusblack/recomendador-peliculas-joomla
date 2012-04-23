<?php
defined('_JEXEC') or die('Restricted access');
?>
<form action="index.php" method="post" name="adminForm">
    <table class="admintable">
        <tr>
            <td width="100" align="right" class="key">
                <label for="idDirector">Nombre:</label>
            </td>
            <td>
            	<select name="idDirector" id="idDirector">
            		<?php 
            		foreach ($this->famosos as $famoso) {
            			$idFamoso = $famoso["id"];
						echo "<option value='$idFamoso'>".$famoso["nombre"]."</option>";
            		}
            		?>
            	</select>
            </td>
        </tr>


    </table>
    <input type="hidden" name="option" value="com_peliculas" />
    <input type="hidden" name="controller" value="films" />
    <input type="hidden" name="id" value="<?php echo $this->film["id"]; ?>" />
    <input type="hidden" name="task" value="grabarDirector" />
</form>